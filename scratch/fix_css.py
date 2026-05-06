
import os

file_path = r'd:\xampp\htdocs\vapestore\public\admin_assets\css\style.css'

with open(file_path, 'rb') as f:
    data = f.read()

# Check for UTF-16 BOM
if data.startswith(b'\xff\xfe') or data.startswith(b'\xfe\xff'):
    print("Detected UTF-16 BOM, converting...")
    content = data.decode('utf-16')
else:
    # Try to remove NUL bytes manually if it's just corrupted ASCII/UTF-8
    print("No BOM detected, attempting to remove null bytes...")
    content = data.replace(b'\x00', b'').decode('utf-8', errors='ignore')

with open(file_path, 'w', encoding='utf-8', newline='\n') as f:
    f.write(content)

print("File repaired successfully.")
