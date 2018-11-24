<script>
 
function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	if(rowCount < 5){                            // limit the user from creating fields more than your limits
		var row = table.insertRow(rowCount);
		var colCount = table.rows[0].cells.length;
		for(var i=0; i <colCount; i++) {
			var newcell = row.insertCell(i);
			newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		}
	}else{
		 alert("Maximum Request is 5");
			   
	}
}

 
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
var table = document.getElementById(btn);
var rowCount = table.rows.length;
      alert(rowCount);
       if(rowCount>1){
  row.parentNode.removeChild(row);
}
}
</script>
 

				
<table id="dataTable" class="form" border="1">
 <tbody>
  <tr>
	<p>
	<td>
	<label for="BX_birth">Berth Pre</label>
	<select id="BX_birth" name="BX_birth" required="required">
		<option>....</option>
		<option>Window</option>
		<option>No Choice</option>
	</select>
	</td>
	<td>
	<label>Name</label>
	<input type="text" name="BX_NAME[]" required="required">
	</td>
	 
	 
	
<td >
		<input type="button" value="Delete" onclick="deleteRow(this)"/>
	</td>
	</p>
  </tr>
 </tbody>

</table>
<p> 
  <input type="button" value="Add Passenger" onClick="addRow('dataTable')" /> 
 
  
</p>
 
