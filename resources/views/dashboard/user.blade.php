<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenido, ') . auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if(!isset($patient))
                    <p class="text-red-500">No tienes información de paciente asociada.</p>
                @else

                <div class="mb-8"><h1 class="txt-title1">INFORMACIÓN DEL PACIENTE</h1></div>
                <div class="grid grid-cols-2 gap-4 text-gray-900 dark:text-white">
                    <h3 class="txt2">Nombre del paciente:</h3><p>{{ $patient->name_patient }}</p>
                    <h3 class="txt2">Carnet de Identidad:</h3><p>{{ $patient->ci_patient }}</p>
                    <h3 class="txt2">Correo Electrónico:</h3><p>{{ $patient->email }}</p>
                    <h3 class="txt2">Fecha de nacimiento:</h3><p>{{ $patient->birth_date }}</p>
                    <h3 class="txt2">Género:</h3><p>{{ $patient->gender }}</p>
                    <h3 class="txt2">Contacto del paciente:</h3><p>{{ $patient->patient_contact }}</p>
                    <h3 class="txt2">Contacto de familiar:</h3><p>{{ $patient->family_contact }}</p>
                </div>

                <div class="mt-8"><h1 class="txt-title2">CITAS PROGRAMADAS</h1></div>
                <div class="grid grid-cols-4 gap-4 border-b border-purple-500 mb-3">
                    <h3 class="txt3">Fecha</h3>
                    <h3 class="txt3">Tipo</h3>
                    <h3 class="txt3">Radiologo</h3>
                </div>
                @if($patient->events->isEmpty())
                    <p class="text-white pl-10">No tiene citas programadas</p>
                @else
                    @foreach($patient->events as $event)
                        <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
                            <p>{{ $event->start_date }}</p>
                            <p>Cita - {{ $event->details }}</p>
                            <p>{{ $event->assignedRadiologist->name }}</p>
                            <div class="flex justify-end mb-4">
                                <a href="{{ route('events.show', $event->id) }}" class="botton3">Detalles</a>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="mt-8 mb-8"><h1 class="txt-title1 mt-6">ESTUDIOS REALIZADOS</h1></div>
                    <div class="grid grid-cols-4 gap-4 border-b border-cyan-500 mb-3">
                        <h3 class="txt4">Fecha</h3>
                        <h3 class="txt4">Tipo</h3>
                        <h3 class="txt4">Radiologo</h3>
                    </div>
                    @if($patient->radiographies->isEmpty() && $patient->tomographies->isEmpty())
                        <p class="text-white pl-10">No tiene estudios realizados</p>
                    @else
                        @foreach($patient->radiographies as $radiography)
                            <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
                                <p>{{ $radiography->radiography_date }}</p>
                                <p>Radiografía - {{ $radiography->radiography_type }}</p>
                                <p>{{ $radiography->radiography_charge }}</p>
                                <div class="flex justify-end mb-4">
                                    <a href="{{ route('radiography.show', $radiography->id) }}" class="botton2">Ver Estudio</a>
                                </div>
                            </div>
                        @endforeach
                        @foreach($patient->tomographies as $tomography)
                            <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
                                <p>{{ $tomography->tomography_date }}</p>
                                <p>Tomografía - {{ $tomography->tomography_type }}</p>
                                <p>{{ $tomography->tomography_charge }}</p>
                                <div class="flex justify-end mb-4">
                                    <a href="{{ route('tomography.show', $tomography->id) }}" class="botton2">Ver Estudio</a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="mt-8 mb-8"><h1 class="txt-title2 mt-6">REPORTES EMITIDOS</h1></div>
                    <div class="grid grid-cols-4 gap-4 border-b border-purple-500 mb-3">
                        <h3 class="txt3">Fecha</h3>
                        <h3 class="txt3">Tipo</h3>
                        <h3 class="txt3">Radiologo</h3>
                    </div>
                    @if($patient->reports->isEmpty())
                        <p class="text-white pl-10">No tienes reportes guardados</p>
                    @else
                        @foreach($patient->reports as $report)
                            <div class="grid grid-cols-4 border-b border-gray-600 gap-4 mb-3 text-white pl-10">
                                <p>{{ $report->report_date }}</p>
                                <p>Reporte - {{ $report->report_id }}</p>
                                <p>{{ $report->created_by }}</p>
                                <div class="flex justify-end mb-4">
                                    <a href="{{ route('report.view', $report->id) }}" target="_blank" class="botton3">Ver Reporte</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
