<h3>Registered Dogs</h3>
{literal}
<script language="JavaScript" type="text/javascript">
function deleteDog(id){
//   CRM.alert("The dog number is\n" + id,"Delete Dog")
   CRM.confirm()
  .on('crmConfirm:yes', function() {
  		CRM.api3('RegisteredDogs', 'delete', {
  "id": id
	}).done(function(result) {
  		CRM.alert("Dog is deleted");
		CRM.refresh;
	});
  })
  .on('crmConfirm:no', function() {
    // Don't do something
  });
}
</script>
{/literal}

<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="RegisteredDogs" style='border-bottom: 1px solid black'><th>Dog Number</th><th>Reg. Name</th><th>Call Name</th><th>Preferred Name</th><th>Gender</th><th>Date of Birth</th><th>Active Date</th><th>Inactive Date</th><th>Breed</th><th>Other Titles</th></tr>
{crmAPI var='result' entity='RegisteredDogs' action='get' contact_id=$uid}
{foreach from=$result.values item=registereddogs}
<t><td>{$registereddogs.id}</td>
<td >{$registereddogs.registered_name}</td>
<td>{$registereddogs.call_name}</td>
<td>{$registereddogs.preferred_name}</td>
<td>{$registereddogs.sex}</td>
<td>{$registereddogs.date_of_birth}</td>
<td>{$registereddogs.active_date}</td>
<td>{$registereddogs.inactive_date}</td>
<td>{$registereddogs.breed_name}</td>
<td>{$registereddogs.other_titles}</td>
<td><a href="{$url}&reset=1&action=update&id={$registereddogs.id}" class="crm-popup"> Edit </a></br><a href="{$url}&reset=1&action=transfer&id={$registereddogs.id}" class="crm-popup"> Transfer </a></br><a href="javascript:deleteDog({$registereddogs.id})"> Delete </a></td></tr>
{/foreach}
<a title="Add a Dog" class="button_name button crm-popup" href="{$url}&reset=1&action=add&cid={$uid}">
  <span>Add Dog</span>
</a>
