@extends('layout.site.grid.double')

@section('content')
    <div class="card-wrap">
        <h2 class="title">Вопрос</h2>
        <form>
            <div class="row">
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-name">Имя <span class="red">*</span></label>
                    <input type="text" class="form-control" id="ask-name">
                </div>
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-email">E-mail <span class="red">*</span></label>
                    <input type="email" class="form-control" id="ask-email">
                </div>
                <div class="col-12 col-md-4 form-group">
                    <label for="ask-name">Тема обращения <span class="red">*</span></label>
                    <select class="form-control" id="ask-name">
                        <option selected="selected" value="">-- Выберите тему</option>
                        <option value="">Прогнозы</option>
                        <option value="">Общие вопросы</option>
                        <option value="">Сотрудничество</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-group">
                    <label for="ask-text">Комментарий <span class="red">*</span></label>
                    <textarea class="form-control" rows="7" id="ask-text"></textarea>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-12 col-lg-6 form-group">
                    <div class="policy-box custom-control custom-checkbox">
                        <input class="custom-control-input policy-check" id="policy" type="checkbox">
                        <label class="custom-control-label" for="policy">Даю согласие на обработку<br>моих
                            <a href="legal-document.php">персональных данных</a></label>
                        <div class="invalid-feedback policy-error">Вы не дали согласие на обработку персональных
                            данных
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 form-group">
                </div>
            </div>

            <div class="btn-account-row">
                <a href="#" class="btn btn-primary pl-4 pr-4">Отправить</a>
            </div>
        </form>
    </div>
@endsection

@section('top')
    @if (filled($document = Text::get($sitesection, 'top')))
        <section class="text-top">
            {!! $document->content !!}
        </section>
    @endif
@endsection

@section('sidebar')
    @include('partial.site.sidebar.info', [
        'current' => 'site.help.ask'
    ])
@endsection

@section('bottom')
    @if (filled($document = Text::get($sitesection, 'bottom')))
        <section class="text-bottom">
            {!! $document->content !!}
        </section>
    @endif
@endsection

