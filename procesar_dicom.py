import pydicom
import numpy as np
import os
import sys
from PIL import Image

# Verificar que se haya pasado un argumento
if len(sys.argv) < 2:
    print("Error: No se proporcionó el nombre del archivo DICOM.")
    sys.exit(1)

# Ruta base donde están los archivos DICOM
base_path = "C:/Users/Gustavo/Desktop/CareRadiologyProject/careradiology/storage/app/public/dicoms/"
file_name = sys.argv[1]  # Nombre del archivo sin extensión

# Ruta completa del archivo DICOM
dicom_path = os.path.join(base_path, file_name)

# Verificar que el archivo existe
if not os.path.exists(dicom_path):
    print(f"Error: El archivo {dicom_path} no existe.")
    sys.exit(1)

# Leer el archivo DICOM
dataset = pydicom.dcmread(dicom_path)

# Convertir a imagen
image_data = dataset.pixel_array.astype(np.float32)
image_data = (image_data - np.min(image_data)) / (np.max(image_data) - np.min(image_data)) * 255
image_data = image_data.astype(np.uint8)

# Convertir a imagen con PIL y guardar
image_pil = Image.fromarray(image_data)
output_path = os.path.join(base_path, f"{file_name}.png")
image_pil.save(output_path, "PNG")

print(f" Imagen procesada y guardada en: {output_path}")
