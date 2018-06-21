<?php
    include_once 'include/head.php';
    $head = new Head("Поиск");
?>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="tab" role="tabpanel">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li role="presentation" class="active"><a href="#countryTab" aria-controls="home" role="tab" data-toggle="tab">Страны</a></li>
                    <li role="presentation"><a href="#addCountyTab" aria-controls="profile" role="tab" data-toggle="tab">Добавление</a></li>
                </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="countryTab">
                            <div class="form-group">
                                <label for="countrySelect">Загруженные страны</label>
                                    <select class="form-control" id="countrySelect">
                                    </select>
                            </div>
                        </div> <!--end div "first panel" -->
                        <div class="tab-pane fade" id="addCountyTab">
                            <div class="form-group">
                                    <label for="country">Добавить страну</label>
                                    <input type="text" class="form-control" id="country" maxlength="50" data-toggle="tooltip" data-placement="top" title="Условия: Первая буква заглавная, только кирилица и дефис" placeholder="Пример: Армения">
                                    <button class="btn btn-default" id="countryBtn"  onclick="addCountry()">Добавить</button>
                            </div>
                        </div> <!--end div "secondary panel" -->
                    </div> <!--end div "tab-content" -->
            </div> <!--end div "tab" -->
        </div> <!--end div "col-md-offset-3" -->
    </div> <!--end div "row" -->
</div> <!--end div "container" -->

<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Информация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                Данные успешно переданны !
            </div>
            <div class="modal-footer">
            </div>
        </div> <!--end div "modal-content" -->
    </div> <!--end div "modal-dialog" -->
</div> <!--end div "modal" -->



<?php
    include_once 'include/footer.php';
?>
</body>
</html>