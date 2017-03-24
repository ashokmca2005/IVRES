$(function(){
	var queryString = getQueryStrings();
	//$('#property_id').val(queryString['property_id']);
	$('#submit_inquiry_button').click(function(){
			$.ajax({
			   type:'POST',
			   data:$('#inquiry_form').serialize(),
			   url: '/submit_inquiry.php',
			   success:function(response){
					$('#messages').empty();
					if(!response.errors){
						if(response.result.InquiryID==""){
							 $('#messages').text(response.result.ErrorDesc);
							 $('#messages').show();
						}else{
							$('#messages').text("Your Inquiry has been submitted successfully");
							$('#messages').show();
							insertInquiryInDB();
							 setTimeout(function(){
								$('#messages').hide();
								//window.history.back()
							 },2000);
						}
					}else{
						
						for(var error in response.errors){
							$('#messages').append("<p>"+response.errors[error]+"</p>");
						}
						$('#messages').show();
					}
			   }
		   });
	});
});

function insertInquiryInDB() { 
	$.ajax({
	   type:'POST',
	   data:$('#inquiry_form').serialize(),
	   url: '/submit_inquiry1.php',
	   success:function(response){
			$('#messages').empty();
			$('#inquiry_form').trigger('reset'); //jquery
			//document.getElementById("inquiry_form").reset(); //native JS
	   }
   });
}

function getQueryStrings() { 
  var assoc  = {};
  var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
  var queryString = location.search.substring(1); 
  var keyValues = queryString.split('&'); 
  for(var i in keyValues) { 
    var key = keyValues[i].split('=');
    if (key.length > 1) {
      assoc[decode(key[0])] = decode(key[1]);
    }
  } 
  return assoc; 
}