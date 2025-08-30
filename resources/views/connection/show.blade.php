<x-app-layout>
    <div class="p-6 space-y-6">
        <h2 class="text-xl font-bold text-cyan-400">Detalle del estudio</h2>

        <div class="bg-gray-800 p-4 rounded-2xl shadow-md text-gray-200">
            <p><strong>ID:</strong> {{ $id }}</p>
            <p><strong>PatientID:</strong> {{ $study['PatientMainDicomTags']['PatientID'] ?? 'N/A' }}</p>
            <p><strong>Nombre Paciente:</strong> {{ $study['PatientMainDicomTags']['PatientName'] ?? 'N/A' }}</p>
            <p><strong>Fecha:</strong> {{ $study['MainDicomTags']['StudyDate'] ?? 'N/A' }}</p>
            <p><strong>Modalidad:</strong> {{ $study['MainDicomTags']['Modality'] ?? 'N/A' }}</p>
            <p><strong>Descripción:</strong> {{ $study['MainDicomTags']['StudyDescription'] ?? 'N/A' }}</p>
        </div>

        {{-- Botón para descargar/guardar --}}
        <a href="{{ url('storage/'.$id.'.zip') }}" class="bg-cyan-500 text-white px-4 py-2 rounded-xl shadow hover:bg-cyan-600">
            Descargar estudio (.zip)
        </a>
    </div>
</x-app-layout>
