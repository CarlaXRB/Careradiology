@extends('layouts._partials.layout') 
@section('title', 'Conexion con el equipo')
@section('subtitle')
    {{ __('Conexión con el Equipo') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('dashboard')}}" class="botton1">Inicio</a>
</div>
    <h2 class="txt-title2">INFORMACIÓN DE CONEXIÓN</h2>
    <div class="flex ml-10 mb-3"><h3 class="txt2">Estado de conexión con el equipo:</h3></div>
        <div class="flex ml-10">
            <button id="check-btn" class="px-4 py-2 rounded-xl font-semibold bg-yellow-400 text-black shadow">Verificar conexión</button>
            <div class="ml-3 mt-2"><span id="status-text" class="ml-3 text-gray-300">Pendiente</span></div>
        </div>
    <div class="p-5 space-y-6">
        @if($studies && count($studies) > 0)
            <div class="p-5">
                <div class="flex mb-5"><h3 class="txt2">Estudios recibidos en el sistema:</h3></div>
                <ul class="list-disc pl-5 text-gray-200">
                    @foreach($studies as $study)
                        <li><a href="{{ route('conexion.show', $study) }}" class="text-white-300 hover:underline">{{ $study }}</a></li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-gray-400">⚠️ No se pudo obtener estudios desde Orthanc.</p>
        @endif
        <hr class="border-gray-600">
        <div class="flex"><h3 class="txt3">Servidor DICOM: </h3></div>
        <div class="bg-gray-900 rounded-2xl shadow-md">
            <iframe src="http://localhost:8042" class="w-full h-[100vh] rounded-b-2xl border-none"></iframe>
        </div>
    </div>
    
<script>
    document.getElementById('check-btn').addEventListener('click', function() {
        let btn = this;
        let statusText = document.getElementById('status-text');

        btn.innerText = 'Verificando...';
        btn.className = 'px-4 py-2 rounded-xl font-semibold bg-gray-500 text-white shadow';
        statusText.innerText = 'Comprobando conexión...';

        fetch("{{ route('conexion.check') }}")
            .then(response => response.json())
            .then(data => {
                if (data.status === 'connected') {
                    btn.innerText = 'Conectado';
                    btn.className = 'px-4 py-2 rounded-xl font-semibold bg-green-500 text-white shadow';
                    statusText.innerText = 'Equipo disponible';
                } else {
                    btn.innerText = 'Desconectado';
                    btn.className = 'px-4 py-2 rounded-xl font-semibold bg-red-500 text-white shadow';
                    statusText.innerText = 'No se pudo conectar';
                }
            })
            .catch(err => {
                btn.innerText = 'Desconectado';
                btn.className = 'px-4 py-2 rounded-xl font-semibold bg-red-500 text-white shadow';
                statusText.innerText = 'Error al conectar';
            });
    });
</script>
@endsection
