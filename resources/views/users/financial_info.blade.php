@extends('layouts.app')
@section('title')
    Financial Information
@endsection

<section class="hero is-white borderBtmLight">
    <nav class="level">
        @include('component.title_set', [
            'spTitle' => 'Financial Information',
            'spSubTitle' => 'Edit user financial information',
            'spShowTitleSet' => true
        ])

        @include('component.button_set', [
            'spShowButtonSet' => true,
            'spAddUrl' => null,
            'spAddUrl' => route('users.create'),
            'spAllData' => route('users.index'),
            'spSearchData' => route('users.search'),
            'spTitle' => 'Users',
        ])

        @include('component.filter_set', [
            'spShowFilterSet' => true,
            'spPlaceholder' => 'Search user...',
            'spMessage' => $message = $message ?? NULl,
            'spStatus' => $status = $status ?? NULL
        ])
    </nav>
</section>
@section('column_left')
    <article class="panel is-primary">
        <p class="panel-tabs">
            <a href="{{ route('users.basic_info', $id) }}">Basic Information</a>
            <a href="{{ route('users.contact_info', $id) }}">Other Information</a>
            <a href="{{ route('users.user_photos', $id) }}">Images</a>
            <a href="{{ route('users.user_permissions', $id) }}">Permissions</a>
            <a href="{{ route('users.financial_info', $id) }}" class="is-active">Financial Information</a>
        </p>

        <div class="customContainer">
            {{ Form::open(array('url' => route('users.financial_info', $id), 'method' => 'post', 'value' => 'PATCH', 'id' => 'add_user', 'files' => true, 'autocomplete' => 'off')) }}
            <div class="columns">
                <div class="column is-6">
                    <div class="field">
                        {{ Form::label('bank_information', 'Bank Information', array('class' => 'label')) }}
                        <div class="control">
                            {{ Form::textarea('bank_information', $user->bank_information, ['required', 'class' => 'textarea', 'placeholder' => 'Enter bank information...']) }}
                        </div>
                    </div>
                </div>
                <div class="column is-6">
                    <span class="field">
                        <label for="mbanking_information" class="label">Mobile Banking Information
                            @if(!empty($user->mbanking_information))
                                <a style="float:right"><span     class="tag is-success is-small" id="addrow">Add More</span    ></a>
                            @endif
                        </label>

                        <div class="control" id="mobileBanking">
{{--                            {{ Form::textarea('mbanking_information', $user->mbanking_information, ['required', 'class' => 'textarea', 'placeholder' => 'Enter bank information...']) }}--}}
                                <?php //dump(explode(' | ', $user->mbanking_information));?>

                                @if(!empty($user->mbanking_information))
                                    @php $explodeBnakingInfo =  explode(' | ', $user->mbanking_information) @endphp
                                    @foreach($explodeBnakingInfo as $key => $data)
                                        @php $mBank = explode(' : ', $data) @endphp
                                    <div class="columns">
                                        <div class="column is-4">
                                            <label for="bill_number" class="label">Select Mobile Banking</label>
                                            <select name="mobile_bank_method[]" id="" class="input is-small" required>
                                                <option value="{{$mBank[0]  ?? NULL}}" selected>{{$mBank[0] ?? NULL}}</option>
                                            </select>
                                        </div>
                                        <div class="column is-7">
                                            <label for="bill_number" class="label">Number</label>
                                            <input name="mobile_bank_number[]" type="number" value="{{$mBank[1] ?? NULL}}" class="input is-small" required>
                                        </div>
                                        <div class="column is-1">
                                            <label></label> <br/>
                                            <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>
                                        </div>
                                    </div>
                                    @endforeach
                                @else

                                <div class="columns">
                                    <div class="column is-4">
                                        <label for="bill_number" class="label">Select Mobile Banking</label>
                                        <select name="mobile_bank_method[]" id="" class="input is-small" required>
                                            <option> </option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Rocket">Rocket</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Cheque">Cheque</option>
                                        </select>
                                    </div>
                                    <div class="column is-7">
                                        <label for="bill_number" class="label">Number</label>
                                        <input name="mobile_bank_number[]" type="number" value="" class="input is-small" required>
                                    </div>
                                    <div class="column is-1">
                                        <label></label> <br/>
                                        <a><span class="tag is-success is-small" id="addrow">Add More</span></a>
                                    </div>
                                </div>
                                @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="columns mb-2">
                <div class="column">
                    <div class="field is-grouped">
                        <div class="control">
                            <input type="submit"
                                   name="financial_info"
                                   class="button is-success is-small"
                                   value="Save Changes"/>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </article>
@endsection

@section('column_right')
@endsection


@section('cusjs')

    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>




    <script>
        //Add Row Function
        $(document).ready(function () {
            var counter = 1;
            $("#addrow").on("click", function () {
                //alert('ok');
                var cols = '<div class="columns r' + counter + '">\
                    <div class="column is-4">\
                        <label for="bill_number" class="label">Select Mobile Banking</label>\
                        <select name="mobile_bank_method[]" id="" class="input is-small" required>\
                            <option> </option>\
                            <option value="Nagad">Nagad</option>\
                            <option value="Bkash">Bkash</option>\
                            <option value="Rocket">Rocket</option>\
                             <option value="Cash">Cash</option>\
                             <option value="Cheque">Cheque</option>\
                        </select>\
                    </div>\
                    <div class="column is-7">\
                        <label for="bill_number" class="label">Number</label>\
                        <input name="mobile_bank_number[]" type="number" value="" class="input is-small" required>\
                    </div>\
                    <div class="column is-1">\
                        <label></label> <br/>\
                        <a><span class="tag is-danger is-small ibtnDel">Delete</span></a>\
                    </div>\
                </div>';

                $("div#mobileBanking").append(cols);
                counter++;
            });


            $("div#mobileBanking").on("click", ".ibtnDel", function (event) {
                $(this).closest("#mobileBanking div.columns").remove();
                counter -= 1
            });
        });

    </script>

@endsection
