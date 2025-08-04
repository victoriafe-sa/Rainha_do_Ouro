document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchInput");
  const tableRows = document.querySelectorAll("#clientesTable tbody tr");

  searchInput.addEventListener("keyup", function () {
    const filtro = searchInput.value.toLowerCase();

    tableRows.forEach(function (row) {
      const nome = row.cells[1].textContent.toLowerCase();
      const telefone = row.cells[2].textContent.toLowerCase();
      const email = row.cells[4].textContent.toLowerCase();

      // Verifica se algum campo contém o termo digitado
      if (nome.includes(filtro) || telefone.includes(filtro) || email.includes(filtro)) {
        row.style.display = ""; // mostra a linha
      } else {
        row.style.display = "none"; // oculta a linha
      }
    });
  });
});
