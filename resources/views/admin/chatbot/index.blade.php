@extends('admin.admin')

@section('title', 'Thống kê Chatbot')

@section('content')
<h2 class="text-2xl font-bold mb-6">Thống kê lượt hỏi Chatbot theo người dùng</h2>

<table class="min-w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200 text-left text-sm text-gray-600 uppercase">
            <th class="py-3 px-4">Tên</th>
            <th class="py-3 px-4">Email</th>
            <th class="py-3 px-4">Số lượt hỏi</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        @foreach($stats as $user)
            <tr class="border-t hover:bg-gray-50">
                <td class="py-2 px-4">{{ $user->name }}</td>
                <td class="py-2 px-4">{{ $user->email }}</td>
                <td class="py-2 px-4 text-blue-600 font-semibold">{{ $user->chatbot_logs_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
