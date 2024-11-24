@extends('layouts._partials.layout')
@section('title', 'Show Tomography')
@section('subtitle')
    {{ __('Medición') }}
@endsection
@section('content')
<div class="flex justify-end">
    <a href="{{ route('tomography.tool', $tomography->id) }}" class="botton1">Atrás</a>
</div>

<div class="flex justify-center mt-[30px] mb-[30px]">
    <div style="position: relative; display: inline-block;">
        <img id="targetImage" src="{{ asset('storage/tomographies/'.$tomography->tomography_uri) }}" width="1000" style="cursor: pointer;" />
        
        <!-- Aquí se dibujan los puntos y las líneas -->
        <div id="pointsContainer"></div>
        <svg id="lineContainer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;"></svg>
    </div>
</div>

<button id="measureDistance" class="botton1 mt-2">Medir Distancia</button>
<button id="measureAngle" class="botton1 mt-2">Medir Ángulo</button>
<p id="distanceDisplay"></p>
<p id="angleDisplay"></p>

<script>
    let points = [];
    let isMeasuringDistance = false;
    let isMeasuringAngle = false;

    document.getElementById('measureDistance').addEventListener('click', function() {
        isMeasuringDistance = !isMeasuringDistance;
        this.textContent = isMeasuringDistance ? 'Dejar de Medir Distancia' : 'Medir Distancia';
        document.getElementById('distanceDisplay').textContent = ''; // Limpiar el texto de distancia
        points = []; // Limpiar puntos anteriores
        document.getElementById('pointsContainer').innerHTML = ''; // Limpiar puntos en el contenedor
        document.getElementById('lineContainer').innerHTML = ''; // Limpiar líneas anteriores
    });

    document.getElementById('measureAngle').addEventListener('click', function() {
        isMeasuringAngle = !isMeasuringAngle;
        this.textContent = isMeasuringAngle ? 'Dejar de Medir Ángulo' : 'Medir Ángulo';
        document.getElementById('angleDisplay').textContent = ''; // Limpiar el texto de ángulo
        points = []; // Limpiar puntos anteriores
        document.getElementById('pointsContainer').innerHTML = ''; // Limpiar puntos en el contenedor
        document.getElementById('lineContainer').innerHTML = ''; // Limpiar líneas anteriores
    });

    document.getElementById('targetImage').addEventListener('click', function(event) {
        const rect = this.getBoundingClientRect();
        const x = event.clientX - rect.left; // coordenada x relativa a la imagen
        const y = event.clientY - rect.top;  // coordenada y relativa a la imagen

        // Si se está midiendo distancia
        if (isMeasuringDistance && points.length < 2) {
            addPoint(x, y);
            if (points.length === 2) {
                drawLine(points[0], points[1]);
                const distance = calculateDistance(points[0], points[1]);
                document.getElementById('distanceDisplay').textContent = `Distancia: ${distance.toFixed(2)} píxeles`;
            }
            return;
        }

        // Si se está midiendo ángulo
        if (isMeasuringAngle && points.length < 3) {
            addPoint(x, y);
            if (points.length === 3) {
                drawLine(points[0], points[1]);
                drawLine(points[1], points[2]);
                const angle = calculateAngle(points[0], points[1], points[2]);
                drawArc(points[0], points[1], points[2]); // Dibuja el arco
                document.getElementById('angleDisplay').textContent = `Ángulo: ${angle.toFixed(2)} grados`;
            }
        }
    });

    function addPoint(x, y) {
        // Marcar el punto
        const point = document.createElement('div');
        point.style.position = 'absolute';
        point.style.width = '8px'; // Tamaño de los puntos ajustado
        point.style.height = '8px'; // Tamaño de los puntos ajustado
        point.style.background = 'purple'; // Color de los puntos
        point.style.borderRadius = '50%';
        point.style.left = `${x}px`;
        point.style.top = `${y}px`;
        point.style.transform = 'translate(-50%, -50%)';
        document.getElementById('pointsContainer').appendChild(point);

        // Añadir el punto a la lista
        points.push({ x: x, y: y });
    }

    function drawLine(point1, point2) {
        const svg = document.getElementById('lineContainer');
        const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
        line.setAttribute("x1", point1.x);
        line.setAttribute("y1", point1.y);
        line.setAttribute("x2", point2.x);
        line.setAttribute("y2", point2.y);
        line.setAttribute("stroke", "green"); // Color de las líneas
        line.setAttribute("stroke-width", "2");
        svg.appendChild(line);
    }

    function drawArc(pointA, pointB, pointC) {
        const svg = document.getElementById('lineContainer');

        // Calcular el centro del arco y el radio
        const radius = 50; // Ajusta el radio según sea necesario
        const angleAB = Math.atan2(pointB.y - pointA.y, pointB.x - pointA.x);
        const angleBC = Math.atan2(pointC.y - pointB.y, pointC.x - pointB.x);
        const midX = pointB.x;
        const midY = pointB.y;

        // Calcular el punto de inicio y final del arco
        const startX = midX + radius * Math.cos(angleAB + Math.PI);
        const startY = midY + radius * Math.sin(angleAB + Math.PI);
        const endX = midX + radius * Math.cos(angleBC);
        const endY = midY + radius * Math.sin(angleBC);

        // Crear el arco
        const arc = document.createElementNS("http://www.w3.org/2000/svg", "path");
        const arcPath = `M ${startX} ${startY} A ${radius} ${radius} 0 0 1 ${endX} ${endY}`;
        arc.setAttribute("d", arcPath);
        arc.setAttribute("stroke", "blue"); // Color del arco
        arc.setAttribute("fill", "none");
        arc.setAttribute("stroke-width", "2");
        svg.appendChild(arc);
    }

    function calculateDistance(point1, point2) {
        const dx = point2.x - point1.x;
        const dy = point2.y - point1.y;
        return Math.sqrt(dx * dx + dy * dy); // Distancia euclidiana
    }

    function calculateAngle(pointA, pointB, pointC) {
        const a = calculateDistance(pointB, pointC);
        const b = calculateDistance(pointA, pointB);
        const c = calculateDistance(pointA, pointC);

        // Usar la ley de los cosenos para calcular el ángulo
        const angleRad = Math.acos((b * b + c * c - a * a) / (2 * b * c));
        const angleDeg = angleRad * (180 / Math.PI);
        return angleDeg;
    }
</script>
@endsection