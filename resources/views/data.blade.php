@extends('layout')

@section('title', 'Таблица данных')

@section('content')
    <h1>Таблица полученных данных</h1>
    <p><a href="{{ route('form') }}">+ Заполнить форму еще раз</a></p>

    @if(empty($items))
        <p><em>Данных пока нет. Пожалуйста, заполните и отправьте форму.</em></p>
    @else
        <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #f2f2f2;">
                <th>№</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Сообщение</th>
            </tr>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['name'] ?? '' }}</td>
                    <td>{{ $item['email'] ?? '' }}</td>
                    <td>{{ $item['message'] ?? '' }}</td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
