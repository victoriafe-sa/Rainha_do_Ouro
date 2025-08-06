function carregarPagina(caminhoHtml, caminhoCss = null) {
    fetch(caminhoHtml)
        .then(response => response.text())
        .then(html => {
            const conteudo = document.getElementById('conteudo');
            conteudo.innerHTML = html;

            // Se existir caminhoCss, adicionar o link dinamicamente
            if (caminhoCss) {
                const existingLink = document.querySelector(`link[data-dynamic="true"]`);
                if (existingLink) existingLink.remove(); // remove o anterior

                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = caminhoCss;
                link.setAttribute('data-dynamic', 'true');
                document.head.appendChild(link);
            }

            // Carregar JS adicional se necessário
            if (caminhoHtml.includes('cadastro_serv-prod.html')) {
                const script = document.createElement('script');
                script.src = '../script/cadastro_serv-prod.js';
                script.defer = true;
                document.body.appendChild(script);
            }

            // Aqui você pode adicionar outros ifs para outras páginas específicas, exemplo:
            if (caminhoHtml.includes('consultar_agend.php')) {
                const script = document.createElement('script');
                script.src = '../script/consultar_agendamento.js'; // se tiver um JS exclusivo
                script.defer = true;
                document.body.appendChild(script);
            }

        })
        .catch(() => {
            document.getElementById('conteudo').innerHTML = "<p>Erro ao carregar a página.</p>";
        });
}
