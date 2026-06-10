import zipfile
import xml.etree.ElementTree as ET
import os

docx_path = r"D:\Dental Pro\DentalPro_AI_Roadmap-4.docx"
output_path = r"C:\Users\NITESH\.gemini\antigravity-ide\brain\aa4f041f-7b62-4a51-b6e4-99decce6204d\roadmap_text.txt"

def docx_to_text(path):
    try:
        with zipfile.ZipFile(path) as z:
            xml_content = z.read('word/document.xml')
            root = ET.fromstring(xml_content)
            
            # Namespaces
            ns = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}
            
            paragraphs = []
            for p in root.iter('{http://schemas.openxmlformats.org/wordprocessingml/2006/main}p'):
                p_text = []
                for t in p.iter('{http://schemas.openxmlformats.org/wordprocessingml/2006/main}t'):
                    if t.text:
                        p_text.append(t.text)
                paragraphs.append(''.join(p_text))
            
            return '\n'.join(paragraphs)
    except Exception as e:
        return f"Error: {str(e)}"

text = docx_to_text(docx_path)
with open(output_path, 'w', encoding='utf-8') as f:
    f.write(text)

print("Roadmap extracted successfully!")
