const pdfjsLib = window['pdfjs-dist/build/pdf'];

document.getElementById('pdfFile').addEventListener('change', async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const fileReader = new FileReader();
    fileReader.onload = async function() {
        const typedarray = new Uint8Array(this.result);
        const pdf = await pdfjsLib.getDocument(typedarray).promise;
        let text = '';
        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const content = await page.getTextContent();
            content.items.forEach((item) => text += item.str + ' ');
        }
        document.getElementById('output').textContent = text.trim();
    };
    fileReader.readAsArrayBuffer(file);
});
