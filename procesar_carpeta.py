import pydicom
import numpy as np
import os
import sys
from PIL import Image

# Verificar que se haya pasado un argumento
if len(sys.argv) < 2:
    print("Error: No se proporcionó el nombre del archivo o carpeta.")
    sys.exit(1)

# Ruta base donde se guardarán las imágenes
output_base_path = sys.argv[1]  # Recibimos la ruta como argumento
input_path = output_base_path  # Puede ser un archivo o una carpeta

print(f"Procesando: {input_path}")  # Verificar ruta recibida

# Función para procesar un archivo DICOM
def process_dicom(file_path, output_path):
    try:
        print(f"Procesando archivo DICOM: {file_path}")  # Depuración
        # Leer archivo DICOM sin importar la extensión
        dataset = pydicom.dcmread(file_path)
        image_data = dataset.pixel_array.astype(np.float32)
        image_data = (image_data - np.min(image_data)) / (np.max(image_data) - np.min(image_data)) * 255
        image_data = image_data.astype(np.uint8)

        image_pil = Image.fromarray(image_data)

        # Guardar la imagen dentro de la misma carpeta
        output_file = os.path.join(output_path, f"{os.path.basename(file_path)}.png")
        image_pil.save(output_file, "PNG")

        print(f"Imagen guardada: {output_file}")

    except Exception as e:
        print(f"Error procesando {file_path}: {str(e)}")

# Verificar si es un archivo o carpeta
if os.path.isfile(input_path):  # Si es un archivo individual
    process_dicom(input_path, os.path.dirname(input_path))

elif os.path.isdir(input_path):  # Si es una carpeta
    # Recorrer todos los archivos de la carpeta
    for file in os.listdir(input_path):
        file_path = os.path.join(input_path, file)

        # Comprobar si es un archivo (y no una subcarpeta)
        if os.path.isfile(file_path):
            process_dicom(file_path, input_path)

else:
    print("Error: El archivo o carpeta no existe.")
