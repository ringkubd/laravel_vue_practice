@extends('layouts.app')

@section('content')
    <?php
    $modelData = $data['model'];
    $translation = json_encode(trans("clients"));
    ?>

    <div class="container" id="content">
        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{trans("clients.client")}}
                    </div>

                    <div class="card-body">
                        <clients-table :data="{{$data['content']}}" :trans="{{$translation}}"></clients-table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
