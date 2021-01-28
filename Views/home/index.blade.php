@extends('layout.base')

@section('content')
    <div class="container mt-5">
        <h1>Welcome to my Code Generator</h1>
        <form method="post" action="/">
            <div class="form-group">
                <label for="length">Length:</label>
                <small class="text-muted">(If larger than combined requirements, the remaining characters will be randomized.)</small>
                <input class="form-control" type="number" min="0" name="length" id="length" value="{{ $length }}">
            </div>

            <div class="form-group">
                <label for="upperCaseAmount">Amount of uppercase:</label>
                <input class="form-control" type="number" min="0" name="upperCaseAmount" id="upperCaseAmount" value="{{ $upperCaseAmount }}">
            </div>

            <div class="form-group">
                <label for="lowerCaseAmount">Amount of lowercase:</label>
                <input class="form-control" type="number" min="0" name="lowerCaseAmount" id="lowerCaseAmount" value="{{ $lowerCaseAmount }}">
            </div>

            <div class="form-group">
                <label for="numbersAmount">Amount of numbers:</label>
                <input class="form-control" type="number" min="0" name="numbersAmount" id="numbersAmount" value="{{ $numbersAmount }}">
            </div>

            <div class="form-group">
                <label for="specialCharactersAmount">Amount of special characters:</label>
                <input class="form-control" type="number" min="0" name="specialCharactersAmount" id="specialCharactersAmount" value="{{ $specialCharactersAmount }}">
            </div>

            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
        @if(isset($password))
            <div class="form-group mt-5">
                <label for="password">Password generated @ {{ date("h:i:s, d/m/Y")." CET"}}:</label>
                <input class="form-control"  type="text" id="password" disabled value="{{ $password }}">
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $('input:not(disabled)').change((event) => {
                fixLength(event);
            });
        });

        function fixLength(event){
            let length = parseInt($('#length').val());

            let upperCase = parseInt($('#upperCaseAmount').val());
            let lowerCase = parseInt($('#lowerCaseAmount').val());
            let numbers = parseInt($('#numbersAmount').val());
            let specialCharacters = parseInt($('#specialCharactersAmount').val());

            if(length < (upperCase+lowerCase+numbers+specialCharacters)) {
                console.log($(event.target))
                if($(event.target).is($('#length')))
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The length has to be higher or equal to the other requirements!',
                    });

                $('#length').val((upperCase+lowerCase+numbers+specialCharacters));
            }
        }
    </script>
@endsection