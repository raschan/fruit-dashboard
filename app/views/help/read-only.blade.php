Creating a read-only API key with Braintree for added security
November 20, 2014 23:29
For added security when using Braintree we recommend taking these steps to only grant ChartMogul read access to certain parts of your Braintree account.

Login as admin to your Braintree account and go to Settings > Users and Roles > Manage Roles > New
Give the role a name like "Read only"
Uncheck all permissions except:
	Download Transactions with Masked Payment Data
	Download Vault Records with Masked Payment Data
	Download Subscription Records
Now click "Create role"
Now go to Settings > Users and roles > New user
	Give the user API Access, assign the read only role and also access to the merchant accounts which you want to be included in ChartMogul (usually all of them).
Now logout of Braintree and log back in as this new 'read only' user.
Then go to Account > My User > Api Keys
Use these API keys in ChartMogul for added security.
 

Here are the rights you need to grant your Braintree user in order for ChartMogul to work: