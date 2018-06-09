function validate_country() {
    var pattern = /^[А-ЯЁ]{1}[А-Яа-яЁё-]{2,50}$/;
    var pattern_hyphen = /-{2,}/;

    var country_input = $('#country');
    var country_btn = $('#countryBtn');

    if (country_input.val().search(pattern) == 0 && country_input.val().search(pattern_hyphen) == -1 )
    {
        country_btn.attr('disabled', true).text('Отправка');
    }
    else
    {
        country_input.addClass('error');
        setTimeout(function() {
            country_input.removeClass('error');}, 1000);

        country_input.tooltip('show');
        setTimeout(function() {
            country_input.tooltip('hide');}, 2000);

        return false;
    }

}

function enable_countryBtn() {
    setTimeout(function() {$(".modal").modal('hide'); }, 3000);
    $('#countryBtn').attr('disabled', false).text('Добавить');
}

function add_country() {

   if (validate_country() == false)
   {
       return false;
   }
   else
   {
       var country = $('#country').val();

       $.ajax({
           url: '/include/ajax.php',
           type: 'POST',
           data: {
               act: 'add_country',
               country: country,
           },
           success: function(mas) {
               if (mas == true)
               {
                   alert(country + " уже существует. Напишите другое название!");
                   enable_countryBtn();
               }
               else
               {
                   $('#modal_info').modal('show',true);
                   enable_countryBtn();
                   country = "";
                   select_country();
               }

           },
           error: function() {
               alert("Ошибка, что-то пошло не так...");
           }
       });
   }
}

function select_country()
{
    $('#countrySelect option').remove();

    $.ajax({
        url: "/include/ajax.php",
        type: "POST",
        dataType: "json",
        data: {
            act: 'select_country',
        },
        success: function (mas) {
            // $("#countrySelect").append( $(' <option value="0" selected disabled>Загруженные страны</option>'));

            for (var key in mas)
            {
                $("#countrySelect").append( $('<option value="' + mas[key]['id'] + '">' + mas[key]['name'] + '</option>'));
            }
        },
        error: function(jqXHR, exception) {
            alert("Ошибка");
            //console.log(jqXHR);
        }
    });
}


$(document).ready(function () {
    select_country();
});