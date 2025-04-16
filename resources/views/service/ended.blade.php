@extends('app')

@section('content')

<div class="container">
    <div class="row mt-4 mb-4">
        <div class="col text-center">
            <h3 class="text-uppercase">L'iniziativa è terminata</h3>
        </div>
    </div>

    <div class="row mt-4 mb-4">
        <div class="col text-center">
            <p class="note">
Iniziativa valida dal {{ Carbon\Carbon::parse(env('CONTEST_START_DATE'))->format('d/m/Y') }} al {{ Carbon\Carbon::parse(env('CONTEST_END_DATE'))->format('d/m/Y') }}. Consulta il <a href="{{ asset('doc/regolamento.pdf')}} " target="_blank" style="text-decoration:underline;">regolamento</a> completo su NIVEA.it<br>
                            </p>
        </div>
    </div>
</div>

@endsection
