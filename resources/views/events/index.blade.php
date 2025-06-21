<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Citas programadas') }}
    </h2>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/locales-all.min.js"></script>

    <style>
      .fc-day-today {
        background-color: rgba(103, 0, 183, 0.5) !important;
      }
      .fc-event.Sala-1 {
        background-color: rgba(86, 255, 25, 0.7) !important; 
        border-color: rgba(81, 255, 17, 0.7) !important;
        color: white !important;
      } 
        .fc-event.Sala-2 {
        background-color: #0066ff !important;
        border-color: #3385ff !important;
        color: white !important;
      }
      .fc-event:hover {
        cursor: pointer !important;
      }
    </style>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const events = @json($events);

        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale: 'es',
          buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
          },
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
          },
          events: events,
          allDaySlot: false, 

          slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
          },

          eventClassNames: function(arg) {
            if (arg.event.extendedProps.room === 'Sala 1') {
              return ['Sala-1'];
            }
            if (arg.event.extendedProps.room === 'Sala 2') {
              return ['Sala-2'];
            }
            return [];
          },

          eventContent: function(arg) {
            if (arg.view.type !== 'dayGridMonth') {
              const start = arg.event.start;
              const end = arg.event.end;
              const room = arg.event.extendedProps.room || '';
              const formatHour = (date) => {
                if (!date) return '';
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
              };

              return {
                html: `
                  <div style="font-size: 0.9rem; font-family: sans-serif; color: #FFFFFF;">
                    <b>${arg.event.title}</b><br>
                    <b>${room}</b><br>
                    Desde: ${formatHour(start)}<br>
                    Hasta: ${formatHour(end)}
                  </div>`
              };
            }
          },

          eventDidMount: function(info) {
            if (info.view.type === 'dayGridMonth') {
              const start = info.event.start;
              const end = info.event.end;
              const room = info.event.extendedProps.room || '';
              const formatHour = (date) => {
                if (!date) return '';
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: false });
              };

              info.el.innerHTML = `
                <div style="font-size: 0.75rem; font-family: sans-serif; color: #fff;">
                  <b>${info.event.title}</b><br>
                  <b>${room}</b><br>
                  Desde: ${formatHour(start)}<br>
                  Hasta: ${formatHour(end)}
                </div>`;
            }
          },

          eventClick: function(info) {
            const eventId = info.event.id;
            window.location.href = `/events/${eventId}`;
          }
        });

        calendar.render();
      });
    </script>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex justify-end">
          <a href="{{ route('events.create') }}" class="botton1">Crear Cita</a>
        </div>
        <div id="calendar" class="p-4 text-gray-800 dark:text-gray-200 font-sans"></div>
      </div>
    </div>
  </div>
</x-app-layout>
