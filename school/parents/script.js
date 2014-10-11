$(document).ready(function () {

$.ajaxSetup({
  url:'api.php',
  type:'post'
})

    $('#add [data-prop=title]').live('keyup',function(event) {
     if ( ($('[data-prop=title]').val()).length > 3)  {
doadd();
  }  

   
   }).keydown(function(event) {
  if (event.which == 13) {
    event.preventDefault();
  }  
});
    
    $('[data-prop=date]').datepicker({
      dateFormat: 'dd/mm/yy',
      defaultDate: 0
    });


$('[data-prop=date]').change(function(){ doadd(); });
$('[data-prop=action]').change(function(){
  $('[data-prop=title]').val('');
  doadd();
})


    $('[data-action=add]').live('click',function(){
      
      doadd();
    })
    
        

    $('#add [data-prop=year]').change(function(){
      doadd();  
    });
    
    
    

    
   $('[data-action=studentbooking]').live('click',function(){
    
    $.ajax({
      data:{
	action: 'bookstudent',
	time: $('[data-prop=timepicker]').val(),
	id: $('[data-action=addbooking]').attr('data-studentid'),
	year: $('[data-prop=year]').val(),
	date: $('[data-prop=date]').val()
      },
      success:function(data){
	$('#timer').html(data);
	bindteacher();
      }
    })
    return false;
   });

    $('[data-action=arrive]').live('click',function(){
      $this = $(this);
      id = $(this).closest('tr').attr('data-id');
      $.ajax({
	data:{
	  action : 'arive',
	  id: id,
	  search: $('#add [data-prop=title]').val(),
	  year: $('#add [data-prop=year]').val(),
	  date: $('#add [data-prop=date]').val(),
	  
	  
	},
	success:function(data){
	  $('#timer').html(data);
	  bindteacher();
	}
      
      });

    });
    
      $('[data-action=seestudent]').live('click',function(){
      $this = $(this);
      id = $(this).closest('tr').attr('data-bookingid');
      
      studentid = $(this).closest('tr').attr('data-id');
      present = $(this).attr('data-present');
      $.ajax({
	data:{
	  action : 'seestudent',
	  bookingid: id,
	  search: $('#add [data-prop=title]').val(),
	  year: $('#add [data-prop=year]').val(),
	  date: $('#add [data-prop=date]').val(),
	  present:present,
	  studentid: studentid
	  
	},
	success:function(data){
	  $('#timer').html(data);
	  bindteacher();
	}
      
      });

    });
      
      $('[data-action=expanduser]').live('click',function(){
	
	
	$this = $(this);
	if($this.closest('tr').find('.review').is(':visible')){
	  $this.closest('tr').find('.review').hide();
	  $this.html('/')
	}
	else{
	$.ajax({
	  
	  data:{
	    studentid : $this.closest('tr').attr('data-id'),
	    date: $('#add [data-prop=date]').val(),
	    action: 'expanduser'
	  },
	  success:function(data){
	    $this.closest('tr').find('.review').show().html(data);
	    $this.html('-')
	    
	  }
	  
	})
	}
      })
      
      
      $('[data-action=deletebooking]').live('click',function(){
      $this = $(this);
      id = $(this).closest('tr').attr('data-bookingid');
      $.ajax({
	data:{
	  action : 'deletebooking',
	  bookingid: id,
	  search: $('#add [data-prop=title]').val(),
	  year: $('#add [data-prop=year]').val(),
	  date: $('#add [data-prop=date]').val()
	  
	},
	success:function(data){
	  $('#timer').html(data);
	  bindteacher();
	}
      
      });

    });

     $('[data-action=leave]').live('click',function(){

      id = $(this).closest('tr').attr('data-id');
      $.ajax({
	data:{
	  action : 'leave',
	  id: id,
	  search: $('#add [data-prop=title]').val(),
	  year: $('#add [data-prop=year]').val(),
	  date: $('#add [data-prop=date]').val()
	  
	},
	success:function(data){
	  $('#timer').html(data);
	}
      
      });

    });   
    


    $('[data-action=fullrefresh]').live('click',function () {
      
      $('#add [data-prop=title]').val('');
      doadd();
      


    });
    
  




    doadd();

});

function doadd(){
    
    $.ajax({

    	data: {
	  search: $('#add [data-prop=title]').val(),
	  action: $('#add [data-prop=action]').val(),
	  year: $('#add [data-prop=year]').val(),
	  date: $('#add [data-prop=date]').val()
	},
    	success: function(data){
    		$('#timer').html(data);
		bindteacher();
    	} 
    
    });
    
    
    
    
    }
    
    function bindteacher(){
    $('[data-action=addbooking]').autocomplete({
			minLength: 3,
			source: "api.php?action=autocomplete&year=" + $('[data-prop=year]').val(),
			select: function( event, ui ) {
				$( "[data-action=addbooking]" ).val( ui.item.label );
				$( "[data-action=addbooking]" ).attr('data-studentid', ui.item.value );
				return false;
			}
		})
   $('[data-prop=timepicker]').timePicker({
      startTime: "15:50",
      endTime: "19:10",
      seperator: ":",
      step:5
    });
   }
   