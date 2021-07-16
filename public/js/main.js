let printBtn = document.querySelector('#printButton');
        if(printBtn)
            printBtn.onclick = () => {
                let report = document.querySelector('[data-printable]');
                let report_prime = report.cloneNode(true);
                let printableWindow = window.open('', 'mywindow', `status=1,width=${report.width},height=${report.height}`);
                
                printableWindow.document.write(
                    `<!DOCTYPE HTML><html dir="rtl"><head><title>Print Me</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap">${document.querySelector('#tailwindcss').outerHTML}</head>`
                );
                printableWindow.document.write('<body class="p-5" onafterprint="self.close()">');
                printableWindow.document.write(report_prime.innerHTML);
                let scrpt = printableWindow.document.createElement('script');
                scrpt.innerText = 'print();';
                printableWindow.document.write(scrpt.outerHTML);
                printableWindow.document.write('</body></html>');
            }

let hideables = document.querySelectorAll('[data-isHideable]');


document.onkeydown = e =>{
    if( e.key == "s"){
        
        hideables.forEach(e=>{
            e.classList.toggle('hidden');
        });
    }
}


if('serviceWorker' in navigator){
    navigator.serviceWorker.register(window.location.origin + '/sw.js');
}

