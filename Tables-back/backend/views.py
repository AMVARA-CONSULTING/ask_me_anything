from django.http import JsonResponse
from .models import *
from django.db import connection

class CursorByName():
    def __init__(self, cursor):
        self._cursor = cursor

    def __iter__(self):
        return self

    def __next__(self):
        row = self._cursor.__next__()

        return { description[0]: row[col] for col, description in enumerate(self._cursor.description) }

def format_json(data, total):
        # Initialize the variables
        return_data = {}
        results = []
        #  to transform to json")
        # Loop items transforming into string and nesting
        for row in CursorByName(data):
            first_level = {}
            second_level = {}
            for k, v in row.items():
                if k in ['run_id', 'date_time', 'status', 'archived']:
                    first_level[k] = v
                elif k not in ['log']:
                    second_level[k] = v
            # Adding the missing variables
            second_level['browser'] = json.loads(second_level['browser'])
            second_level['archived'] = first_level['archived']
            second_level['status'] = first_level['status']
            second_level['executed_by'] = second_level['executed_by_id']
            first_level['feature'] = second_level['feature_id_id']
            # Remove useless keys and values
            second_level.pop('feature_id_id')
            second_level.pop('executed_by_id')
            # Join dictionaries and arrays
            arr = [second_level]
            first_level['feature_results'] = arr
            results.append(first_level)
        # Add the main variables and the array of tests
        return_data['count'] = (total)
        return_data['next'] = 'http://localhost/api/feature_results/?archived=false&feature_id=240&page=3&size=1'
        return_data['previous'] = 'http://localhost/api/feature_results/?archived=false&feature_id=240&page=1&size=1'
        return_data['results'] = results
        return(return_data)

def send_json(request):
        feature_id = 1
        total_amount = """
        select count(*) from backend_feature_runs where feature_id = %s
        """ % (feature_id)
        cursorb = connection.cursor()
        cursorb.execute(total_amount)
        # Get the total amount of tests
        for p in CursorByName(cursorb):
                total = p['count']
        # Query to get all the test of feature id
        q = """
        select *, to_char(date_time, 'YYYY-MM-DD"T"HH:MI:SSZ') as date_time, to_char(result_date, 'YYYY-MM-DD"T"HH:MI:SSZ') as result_date from view_feature_run_results where feature_id = %s order by run_id DESC limit %s offset %d
        """ % ( feature_id, request.GET.get('size', '25'), int(request.GET.get('size', 25))*int(request.GET.get('page', 1))-int(request.GET.get('size', 25)))
        cursor = connection.cursor()
        cursor.execute(q)
        result = format_json(cursor, total)
        # works but slow
        # feature_runs = Feature_Runs.objects.filter(feature=feature_id, archived=archived, ).order_by('-date_time', '-run_id' ).prefetch_related("feature_results")
        # # get the amount of data per page using the queryset
        # page = self.paginate_queryset(feature_runs)
        # serialized_data = FeatureRunsSerializer(page, many=True, read_only=True).data
        # # return the data with count, next and previous pages.
        # ret = self.get_paginated_response(serialized_data)
        result_return = JsonResponse(result)
        end = time.time()
        return result_return # <100ms con 500 Lineas ... que pasa con 5000 Lineas