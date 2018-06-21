/*
    Валидация ввода стран
    return false - если валидация не прошла
*/
function validateCountry() {
    var pattern = /^[А-ЯЁ]{1}[А-Яа-яЁё-]{2,50}$/;
    var pattern_hyphen = /-{2,}/;

    var country_input = $('#country');
    var country_btn = $('#countryBtn');

    // проверка на (Кирилицу и первую заглавную) и (количество повторяющих дефисов)
    if (country_input.val().search(pattern) == 0 && country_input.val().search(pattern_hyphen) == -1)
    {
        country_btn.attr('disabled', true).text('Отправка');
    }
    else // вывод tooltip-а и красного обода вокруг input-а в течентт 1-2 сек
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

/*
    Закрытие модального окна
    и изменение (текста и свойства disable) кнопки добавления страны
*/
function enableCountryBtn()
            {
                 setTimeout(function() {
                            $(".modal").modal('hide'); }, 3000);
                            $('#countryBtn').attr('disabled', false).text('Добавить');
            }


/*
    Фунция добавления страны через ajax
    return false -  если не прошла валидацию
*/
function addCountry() {

   if (validateCountry() == false)
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
                   enableCountryBtn();
               }
               else
               {
                   $('#modal_info').modal('show',true);
                   enableCountryBtn();
                   country = "";
                   selectCountry();
               }

           },
           error: function() {
               alert("Ошибка, что-то пошло не так...");
           }
       });
   }
}

/*
    Фунция получения стран через ajax и вывода в селект
*/
function selectCountry()
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

/*
    Вывод стран в селект при загрузки страницы
*/
$(document).ready(function () {
    selectCountry();
});