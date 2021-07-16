import logging
import os.path
import time
import subprocess
import requests
from PIL import Image

# backend version number, incremented when ever backend is updated
version = '2.5.72'
# browserstack caching time in seconds
# used in URL to cache the browserstack response
# which throws response time from 1.4s to 150ms at most.
browserstackCacheTime = 604800 # one week
# datetime format used to save date and time
datetimeFormat = "%Y-%m-%dT%H:%M:%S"
# datetie format with timezone information
datetimeTZFormat = "%Y-%m-%dT%H:%M:%SZ"
# used to cut the feature name with "..." when sending PDF email
emailSubjectFeatureNameLimit = 20
# used to cut the file download name in the PDF export
pdfDownloadNameLimit = 20
# if pdf file passes this limit, link to download pdf will be sent instead of the pdf.
pdfFileSizeLimit = 10485760 # 10MB
# debug level for behave output
# 10 = DEBUG
# 20 = INFO
# 30 = WARNING
# 40 = ERROR
# 50 = CRITICAL
BEHAVE_DEBUG_LEVEL = 10
# logger format
# more options can be found at https://docs.python.org/3/library/logging.html#logrecord-attributes
# Full logger example:
# LOGGER_FORMAT = '[%(asctime)s][%(name)s][%(levelname)s][%(filename)s:%(lineno)d](%(funcName)s) - %(message)s'
LOGGER_FORMAT = '\33[96m[%(asctime)s][%(filename)s:%(lineno)d](%(funcName)s) -\33[0m %(message)s'
LOGGER_DATE_FORMAT = '%Y-%m-%d %H:%M:%S'

# setup logging
logger = logging.getLogger(__name__)
logger.setLevel(BEHAVE_DEBUG_LEVEL)
# create a formatter for the logger
formatter = logging.Formatter(LOGGER_FORMAT, LOGGER_DATE_FORMAT)
# create a stream logger
streamLogger = logging.StreamHandler()
# set the format of streamLogger to formatter
streamLogger.setFormatter(formatter)
# add the stream handle to logger
logger.addHandler(streamLogger)

# Getter: Retrieve a model using the class itself or Model ID
def get_model(obj, model):
    if isinstance(obj, model):
        return obj
    if isinstance(obj, int):
        try:
            return model.objects.get(pk=obj)
        except model.DoesNotExist:
            raise Exception('Unable to resolve model %s with pk=%d' % (str(model), obj))
    raise Exception('Unable to resolve %s with argument type %s' % (str(model), type(obj)))

# Converts a given image path PNG to WebP
def toWebP(image):
    compressedImage = image.replace('.png', '.webp')
    logger.debug("toWebp function converting: %s to %s" % (image, compressedImage) )
    # Open PNG image
    try:
        im = Image.open(image)
        im = im.convert("RGB")
        im.save(compressedImage, optimize=True, quality=70)
    except Exception as err:
        print('Failed to compress %s' % image)
        logger.debug('Failed to compress %s' % image)
        logger.debug("Str err: %s" % str(err) )

    # sleep 100ms and check that file has been converted correctly otherwise try to convert using imagick
    time.sleep(0.1)
    if os.path.isfile(compressedImage):
        logger.debug("Ckecked using os.path.isfile that File was save on disk ok - %s" % compressedImage )
    else:
        logger.debug("File was not saved ... falling back to convert")
        cmd = 'convert %s -define webp:lossless=true %s' % (image, compressedImage )
        status = subprocess.call(cmd, shell=True, env={})
        logger.debug("returncode status from fallback to convert: %s" % status)

    # check if pngs on disk can be removed
    logger.debug("Checking again using os.path.isfile that File was save on disk ok - %s" % compressedImage )
    if os.path.isfile(compressedImage):
        logger.debug("Image is there ... so we can safely remove PNG")
        os.remove(image)
    else:
        logger.debug("Leaving PNG image as is because WEBP was not there")

# Remove the given prefix from a string
def removePrefix(text, prefix):
    if text.startswith(prefix):
        return text[len(prefix):]
    return text

def getBrowserKey(browser_info):
    return ('%s-%s-%s-%s-%s-%s' % (
        browser_info.get('browser', None),
        browser_info.get('browser_version', None),
        browser_info.get('device', None),
        browser_info.get('os', None),
        browser_info.get('os_version', None),
        browser_info.get('real_mobile', None)
    )).replace(' ', '')

# Allows to automatically retrieve a step result path knowing each Id
# pass getStepResultPath(prefix=x) for getting the path with a prefix, like the root folder
def getStepResultScreenshotsPath(featureId, runId, featureResultId, runHash, stepResultId, **kwargs):
    # Get prefix keyword
    prefix = kwargs.get('prefix', '')
    # Construct path
    return '%s%s/%s/%s/%s/%s/' % (str(prefix), str(featureId), str(runId), str(featureResultId), runHash, str(stepResultId))

# Allows to set a schedule for a given feature Id
# Returns the response object
def set_test_schedule(feature_id, schedule):
    post_data = {'feature_id': feature_id, 'schedule': schedule}
    return requests.post('http://behave:8001/set_test_schedule/', data=post_data)