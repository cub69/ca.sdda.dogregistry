{* HEADER *}
<script language="JavaScript" type="text/javascript">
{literal}
CRM.$(function($) {
  var active = 'a.button, a.action-item:not(.crm-enable-disable), a.crm-popup';
  $('#crm-main-content-wrapper')
    // Widgetize the content area
    .crmSnippet()
    // Open action links in a popup
    .off('.crmLivePage')
    .on('click.crmLivePage', active, CRM.popup)
    .on('crmPopupFormSuccess.crmLivePage', active, CRM.refreshParent);
});
{/literal}</script>

  <script language="JavaScript" type="text/javascript">
  {literal}
  function retire(id){
     CRM.confirm()
    .on('crmConfirm:yes', function() {
      var nowDate = new Date(); 
      var date = nowDate.getFullYear()+'-'+nowDate.getMonth()+'-'+nowDate.getDate(); 
        CRM.api3('RegisteredDogs', 'create', {
    "id": id, 'inactive_date': date,
    }).done(function(result) {
        CRM.alert("Dog has been retired");
      CRM.refresh;
    });
    })
    .on('crmConfirm:no', function() {
      // Don't do something
    });
  }
{/literal}
  </script>
  
{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

<div class="help">
      <p><strong>Registered Dogs and Cards</strong></p>
      <br>
      <p> Welcome to your registered dogs listing.  We have added a feature for you to retire a dog.  There are many reasons you would want to do this, the dog is no longer able to perform in the sport, or has passed away.  Retiring will prevent the dog from being listed on these pages, but does not ever delete the dog and their earned titles.  That information will always be available on the Titles & Qs Report.</p>
      <p> Below you can also obtain your dog's registration card.  Select the name of your dog from the drop down box below and select the 'send card' button.</p>
    </div>

<h3>Registered Dogs</h3>
<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="Dogs" style='border-bottom: 1px solid black'><th>Dog Number</th><th>Registered Name</th><th>Call Name</th><th>Date of Birth</td></tr>
{crmAPI var='dogs' entity='RegisteredDogs' action='get' contact_id = $contactid}

{foreach from=$dogs.values item=dog}
  {if $dog.inactive_date == ''}
    <tr><td>{$dog.id}</td>
    <td>{$dog.registered_name}</td>
    <td>{$dog.call_name}</td>
    <td>{$dog.date_of_birth}</td>
    <td><a title="Retire" class="button_name button" href='javascript:retire({$dog.id})'>Retire</td></tr>
  {/if}
{/foreach}
</table>
<br><br>
{foreach from=$elementNames item=elementName}
  <div class="crm-section">
    <div class="label"><small>{$form.$elementName.label}</small></div>
    <div class="content"><small>{$form.$elementName.html}</small></div>
    <div class="clear"></div> 
  </div>
{/foreach}

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
