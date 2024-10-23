<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data user</title>
</head>
<body>
    <h1>Data user</h1>
    <a href="/user/tambah">+ Tambah User</a> 
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Username</td>
            <td>Nama</td>
            <td>ID Level pengguna</td>
            <td>Kode Level</td>
            <td>Nama Level</td>
            <td>Aksi</td>
        </tr> 
        @foreach ($data as $d)
            <tr>
                <td> {{$d->user_id}} </td>
                <td> {{$d->username}} </td>
                <td> {{$d->nama}} </td>
                <td> {{$d->level_id}} </td>
                <td> {{$d->level->Level_kode}} </td>
                <td> {{$d->level->level_nama}} </td>
                <td><a href="/user/ubah/{{ $d->user_id}}">Ubah</a> | <a href="/user/hapus/{{ $d->user_id}}">Hapus</a></td>
            </tr>
        @endforeach

        {{-- js 4 prak 2.1 (2) --}}
        {{-- <tr>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->username }}</td>
            <td>{{ $data->nama }}</td>
            <td>{{ $data->level_id }}</td>
        </tr> --}}
{{-- 
        {{-- js 4 prak 2.3 (3) --}}
        {{-- <tr>
            <th>Jumlah Pengguna</th>
        </tr> --}}
        {{-- @foreach ($data as $d) --}}
        {{-- <tr>
            <td>{{$jumlahPengguna}}</td>
        </tr> --}}
        {{-- @endforeach --}} 

    </table>
</body>
</html>