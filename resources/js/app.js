const form = document.getElementById('filtro-tutores');

if (form) {
    const container = document.getElementById('lista-tutores');
    let timer = null;
    let controller = null;

    const buscar = () => {
        controller?.abort();                 // cancela requisição anterior
        controller = new AbortController();

        const params = new URLSearchParams(new FormData(form));
        params.forEach((valor, chave) => {
            if (!valor.trim()) params.delete(chave);   // não manda campo vazio
        });

        container.style.opacity = '0.5';     // feedback de carregando

        fetch(`${form.action}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal: controller.signal,
        })
            .then((res) => res.text())
            .then((html) => { container.innerHTML = html; })
            .catch((err) => { if (err.name !== 'AbortError') console.error(err); })
            .finally(() => { container.style.opacity = '1'; });
    };

    form.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(buscar, 300);     // debounce de 300ms
    });

    form.addEventListener('submit', (e) => { e.preventDefault(); buscar(); });

    document.getElementById('limpar-filtro')?.addEventListener('click', () => {
        form.reset();
        buscar();
    });
}