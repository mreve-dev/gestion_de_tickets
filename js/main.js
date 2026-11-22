const newColumn = document.querySelector(".column--new");
const unresolvedColumn = document.querySelector(".column--unresolved");
const resolvedColumn = document.querySelector(".column--resolved");
const closedColumn = document.querySelector(".column--closed");
const tabs = document.querySelectorAll("nav button");
const columns = document.querySelectorAll(".column");




// afficher la bonne colonne au click
tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    columns.forEach((c) => c.classList.remove("is-active"));

    const targetColumn = document.querySelector(
      `.column--${tab.dataset.status}`,
    );

    targetColumn.classList.add("is-active");

    // tous les boutons perdent le fond blanc
    tabs.forEach((t) => t.setAttribute("aria-pressed", "false"));

    // le bouton cliqué prend le fond blanc
    tab.setAttribute("aria-pressed", "true");
  });
});


