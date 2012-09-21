$(function(){
    $('#content').hide().fadeIn('slow');

    $('.datetimetextfield').datetimepicker({
        ampm: true
    });

    $('.datetextfield').datepicker();

});

// Question 4: Add and remove action
$(function(){

    // set the listeners for previously created dynamic dates
    for(sub_question=1; sub_question <= 3; ++sub_question){
        $('div#q_4-'+sub_question+'_add_button').bind('click', {sub_question: sub_question}, add_date_action);

        $('div[id^="q_4-'+sub_question+'_"]').each(function(){
            $(this).children("div.remove_button_container").bind('click', {sub_question: sub_question}, remove_date_action);
        });
    }

    function remove_date_action(e){
        var sub_question = e.data.sub_question;
        var number_dates_added = $('div[id^="q_4-'+sub_question+'_"]').length;

        // At least one date is required
        if( number_dates_added == 1){
            return false;
        }
        
        var date_id = $(this).attr("data-date_index"); 
        
        console.log('#q_4-'+sub_question+'_'+ date_id);
        $('#q_4-'+sub_question+'_'+ date_id).remove();

        var counter = 2;
        $('#dynamic_dates_4-'+sub_question).children().children('input').each(function(){
            $(this).attr({name:'question_4_sub_'+sub_question+ '_date_'+ counter});
            counter++;
        });
    }

    function add_date_action(e){
        var sub_question = e.data.sub_question;
        var number_dates_added = $('div[id^="q_4-'+sub_question+'_"]').length + 1;

        if(number_dates_added >= 20){
            return;
        }

        // create the dom object
        var date_div = $(''+
            '<div class="inserted_date" id="q_4-'+sub_question+'_'+number_dates_added+'">'+ // the date div must have an id in order to identify it for deletion
                '<div class="remove_button_container" data-date_index="'+number_dates_added+'">'+
                    '<img class="add_remove"  src="../resources/img/remove.gif"/>'+
                '</div>'+
                '<input type="text" class="datetextfield textfield"  name="question_4_sub_'+sub_question+'_date_'+number_dates_added+'" value="" placeholder="mm/dd/yyyy"/>'+
            '</div>');
      
        date_div.find('.remove_button_container').bind('click', {sub_question: sub_question}, remove_date_action); // set the remove button action listener 
        date_div.find('input.datetextfield').datepicker();
        date_div.appendTo('#dynamic_dates_4-'+sub_question).hide().fadeIn('fast');
    };

});

$(function(){
    var employment = $('#question_5').val();
    if(employment == 'unemployed'){
        // Fade out
        $("#question_7_2").fadeTo("fast", 0.3);

        // Diable Text Input
        $("#question_7_sub_2").attr("disabled", true);
        $("#add_workschedule_button").attr("disabled", true);
        $("#remove_workschedule_button").attr("disabled", true);
        $("#question_7_sub_2_start_date_1").attr("disabled", true);
        $("#question_7_sub_2_end_date_1").attr("disabled", true);
    }
});

// QUESTION 5
$(function(){
    $('#question_5').change(function() {
        employment = $(this).val();
        if(employment == 'unemployed'){
            // Fade out
            $("#question_7_2").fadeTo("fast", 0.3);

            // Diable Text Input
            $("#q7_2").val("0");
            $("#question_7_sub_2").attr("disabled", true);
            $("#add_workschedule_button").attr("disabled", true);
            $("#remove_workschedule_button").attr("disabled", true);
            $("#question_7_sub_2_start_date_1").attr("disabled", true);
            $("#question_7_sub_2_end_date_1").attr("disabled", true);
        }else{
            // Fade out
            $("#question_7_2").fadeTo("fast", 1);

            // Enable Text Input
            $("#q7_2").val("");
            $("#question_7_sub_2").removeAttr("disabled", true);
            $("#add_workschedule_button").removeAttr("disabled", true);
            $("#remove_workschedule_button").removeAttr("disabled", true);
            $("#question_7_sub_2_start_date_1").removeAttr("disabled", true);
            $("#question_7_sub_2_end_date_1").removeAttr("disabled", true);
        }
   });
});


$(function(){
    var schedules = 2;
    
    for(var sub_question_number=2; sub_question_number <= 4; ++sub_question_number){
        $('div#add_schedule_7_'+ sub_question_number).bind('click', {sub_question_id: sub_question_number}, add_schedule_event);
        $('div[id^="question_7-'+sub_question_number+'_schedule_"]').each(function(){
            $(this).bind('click',{sub_question_id: sub_question_number}, remove_schedule_action);
        });
    }

    function add_schedule_event(e){
        var sub_question_id = e.data.sub_question_id;
        var number_schedules_added = $('div[id^="q_7-'+sub_question_id+'_"]').length + 1;
        console.log("add "+sub_question_id+", "+number_schedules_added);
        if(number_schedules_added >= 20){
            return false;
        }

        var new_schedule_dom_object = $('<div class="inserted_date date_time" id="q_7-'+sub_question_id+'_'+number_schedules_added+'">'+
            '<div class="remove_button_container" id="question_7-'+sub_question_id+'_schedule_'+number_schedules_added+'" data-remove_id="'+number_schedules_added+'">'+
                '<img  class="add_remove" src="../resources/img/remove.gif"/>'+
            '</div>'+
            '<div class="schedule">'+
                '<label class="start_date_time">Start Date and Time:</label>'+
                    '<input type="text" class="datetimetextfield textfield" name="question_7_sub_'+sub_question_id+'_start_date_'+number_schedules_added+'"'+
                        'placeholder="mm/dd/yyyy hh:mm am/pm" />'+
                '<label class="end_date_time">End Date and Time:</label>'+
                    '<input type="text" class="datetimetextfield textfield" name="question_7_sub_'+sub_question_id+'_end_date_'+number_schedules_added+'"'+
                        'placeholder="mm/dd/yyyy hh:mm am/pm" />'+
            '</div>'+
        '</div>');

        new_schedule_dom_object.children(".remove_button_container").bind('click', {sub_question_id: sub_question_id}, remove_schedule_action);
        new_schedule_dom_object.find('.datetimetextfield').datetimepicker();
        new_schedule_dom_object.appendTo('#dynamic_entries_7-'+sub_question_id).hide().fadeIn('slow');
    };
    
    /**
     * Removes the schedule div associated with the 
     * action caller.
     * @param e event object 
     */
    function remove_schedule_action(e){
        var sub_question_id = e.data.sub_question_id;
        var number_schedules_added = $('div[id^="q_7-'+sub_question_id+'_"]').length;

        console.log("remove "+ sub_question_id+", "+ number_schedules_added); 
        if(number_schedules_added == 1){
            return false;
        }

        var id = $(this).attr('data-remove_id');
        $('#q_7-'+sub_question_id+'_'+id).remove();

        var index = 2;
        $('#dynamic_entries_7-'+sub_question_id).children().each(function(){
            $(this).find('input').each(function(){
                var id = $(this).attr('name');
                var exploded_id = id.split("_");
        
                exploded_id[exploded_id.length-1] = index;
                
                $(this).attr({name: exploded_id.join('_')});
            });
            index++;
        });
    };
});

