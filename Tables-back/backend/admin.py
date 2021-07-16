from django.contrib import admin
from .models import *

# OIDCAccount class to admin view
class AdminOIDCAccount(admin.ModelAdmin):
    model = OIDCAccount
    search_fields = ['name', 'email']
    list_filter = ('user_permissions',)
    list_display = ('name', 'email', 'user_permissions')
# Account Department mapping to admin view
class AdminAccount_role(admin.ModelAdmin):
    model = Account_role
    search_fields = ['user__name', 'department__department_name']
    list_display = ('user', 'department')

class AdminStep(admin.ModelAdmin):
    model = Step
    list_display = ('step_content', 'enabled')
    list_filter = ('enabled',)

class AdminStep_result(admin.ModelAdmin):
    model = Step_result
    list_display = ('step_name', 'execution_time', 'success')
    list_filter = ('success',)

class AdminFeature(admin.ModelAdmin):
    model = Feature
    search_fields = ['feature_name', 'app_name', 'environment_name', 'department_name', 'description', 'browsers']
    list_display = ('feature_name', 'app_name', 'environment_name', 'steps', 'department_name', 'depends_on_others', 'cloud')
    list_filter = ('depends_on_others','cloud')

class AdminFeature_result(admin.ModelAdmin):
    model = Feature_result
    search_fields = ['feature_name', 'app_name', 'environment_name', 'department_name']
    list_display = ('feature_name', 'result_date', 'app_name', 'environment_name', 'department_name', 'total', 'fails', 'ok', 'skipped', 'execution_time', 'pixel_diff', 'success')
    list_filter = ('result_date', 'success')

class AdminFolder(admin.ModelAdmin):
    model = Folder
    search_fields = ['name', 'owner__name']
    list_display = ('folder_id', 'name', 'owner')

class AdminFolder_Feature(admin.ModelAdmin):
    model = Folder_Feature
    search_fields = ['folder__name', 'feature__name']
    list_display = ('folder', 'feature')

class AdminPermissions(admin.ModelAdmin):
    readonly_fields=('view_admin_panel',)
    fieldsets = (
        ('Basic', {
            'fields': ('permission_name',),
            'description': 'If any of the permissions are set to False, the user will be able to modfiy, delete, etc their objects like features, etc.'
        }),
        ('OIDC Accounts', {
            'fields': (('create_account', 'edit_account', 'delete_account', 'view_accounts'),)
        }),
        ('Departments', {
            'fields': (('create_department', 'edit_department', 'delete_department'),)
        }),
        ('Applications', {
            'fields': (('create_application', 'edit_application', 'delete_application'),)
        }),
        ('Environments', {
            'fields': (('create_environment', 'edit_environment', 'delete_environment'),)
        }),
        ('Browsers', {
            'fields': (('create_browser', 'edit_browser', 'delete_browser'),)
        }),
        ('Features', {
            'fields': (
                ('create_feature', 'edit_feature', 'delete_feature', 'run_feature', 'view_feature'),
                )
        }),
        ('Step Results', {
            'fields': (
                ('remove_screenshot'),
                )
        }),
        ('Feature Results', {
            'fields': (
                ('remove_feature_result', 'download_result_files'),
                )
        }),
        ('Feature Runs', {
            'fields': (
                ('remove_feature_runs'),
                )
        }),
        ('FrontEnd', {
            'fields': (
                ('view_admin_panel', 'view_departments_panel', 'view_applications_panel', 'view_browsers_panel', 'view_environments_panel', 'view_features_panel', 'view_accounts_panel'),
                )
        }),
        ('Environment Variables', {
            'fields': (
                ('create_variable', 'edit_variable', 'delete_variable'),
                )
        })
    )

class AdminEnvironmentVariables(admin.ModelAdmin):
    model = EnvironmentVariables
    search_fields = ['variable_name', 'variable_value']
    list_display = ('department', 'environment', 'variable_name', 'variable_value')

class AdminCloud(admin.ModelAdmin):
    model = Cloud
    search_fields = ['name']
    list_display = ("name", "active")

class AdminSubscription(admin.ModelAdmin):
    model = Subscription
    search_fields = ['name', 'cloud', 'price_hour', 'fee']
    list_display = ('name', 'cloud', 'euro_price', 'euro_fee', 'live_stripe_price_id', 'live_stripe_subscription_id', 'test_stripe_price_id', 'test_stripe_subscription_id')
    list_filter = ('cloud', )

    def euro_price(self, obj):
        return '%.2f €' % obj.price_hour
    def euro_fee(self, obj):
        return '%.2f €' % obj.fee

class AdminPaymentRequest(admin.ModelAdmin):
    model = PaymentRequest
    search_fields = ['stripe_session_id', 'status', 'error']
    list_display = ('user', 'subscription', 'stripe_session_id', 'status', 'error', 'created_on')

class AdminStripeWebhooks(admin.ModelAdmin):
    model = StripeWebhook
    search_fields = ['event_type', 'event_json']
    list_display = ('event_type', 'handled', 'event_json', 'received_on', )
    list_filter = ('event_type', 'handled', )

class AdminUserSubscription(admin.ModelAdmin):
    model = UserSubscription
    search_fields = ['user', 'subscription', 'period_start', 'period_end', 'stripe_subscription_id']
    list_display = ('user', 'subscription', 'period_start', 'period_end', 'stripe_subscription_id' )
    list_filter = ('user', 'subscription', 'period_start', 'period_end', )

class AdminUsageInvoice(admin.ModelAdmin):
    model = UsageInvoice
    search_fields = ['user', 'stripe_invoice_id', 'status', 'error']
    list_display = ('user', 'stripe_invoice_id', 'period_start', 'period_end', 'hours', 'cloud', 'status', 'modified_on', )
    list_filter = ('user', 'cloud', 'status')

admin.site.register(OIDCAccount, AdminOIDCAccount)
admin.site.register(Account_role, AdminAccount_role)
admin.site.register(Step, AdminStep)
admin.site.register(Step_result, AdminStep_result)
admin.site.register(Feature, AdminFeature)
admin.site.register(Feature_result, AdminFeature_result)
admin.site.register(Folder, AdminFolder)
admin.site.register(Folder_Feature, AdminFolder_Feature)
admin.site.register(Feature_Runs)
admin.site.register(MiamiContact)
admin.site.register(Application)
admin.site.register(Environment)
admin.site.register(Department)
admin.site.register(Browser)
admin.site.register(Action)
admin.site.register(Permissions, AdminPermissions)
admin.site.register(EnvironmentVariables, AdminEnvironmentVariables)
admin.site.register(Cloud, AdminCloud)
admin.site.register(AuthenticationProvider)
admin.site.register(Schedule)
admin.site.register(Invite)
admin.site.register(Integration)
admin.site.register(IntegrationPayload)
admin.site.register(Subscription, AdminSubscription)
admin.site.register(PaymentRequest, AdminPaymentRequest)
admin.site.register(StripeWebhook, AdminStripeWebhooks)
admin.site.register(UserSubscription, AdminUserSubscription)
admin.site.register(UsageInvoice, AdminUsageInvoice)

# Register your models here.
