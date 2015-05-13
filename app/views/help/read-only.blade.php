<p class='lead'>Creating a read-only API key with Braintree for added security</p>

<p>For added security when using Braintree we recommend taking these steps to only grant Fruit Analytics read access to certain parts of your Braintree account.</p>

<p>Login as admin to your Braintree account and go to Settings > Users and Roles > Manage Roles > New</p>
<ol>
	<li>Give the role a name like "Read only"</li>
	<li>Uncheck all permissions except:
  	<ol>
  		<li>Download Transactions with Masked Payment Data</li>
  		<li>Download Vault Records with Masked Payment Data</li>
      <li>Download Subscription Records</li>
  	</ol>
  </li>
  <li>Now click "Create role"</li>
  <li>Now go to Settings > Users and roles > New user
    <ol>
      <li>Give the user API Access</li>
      <li>Assign the read only role and also access to the merchant accounts which you want to be included in Fruit Analytics (usually all of them)</li>
    </ol>
  </li>
  <li>Now logout of Braintree and log back in as this new 'read only' user</li>
  <li>Then go to Account > My User > Api Keys</li>
  <li>Use these API keys in Fruit Analytics for added security.</li>
</ol>
<p>Here are the rights you need to grant your Braintree user in order for Fruit Analytics to work:</p>	
{{HTML::image('img/braintree_role_requirements.png','',array('style'=>'width:100%'))}}