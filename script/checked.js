// Get the search input and checkboxes container
const searchInput = document.getElementById('checkboxSearchDire');
const checkboxContainer = document.getElementById('checkboxContainerDire');

// Get all checkboxes with the 'checkbox' class
const checkboxes = document.querySelectorAll('.checkbox-container-Dire');

// Add an event listener to the search input
searchInput.addEventListener('input', filterCheckboxes);

function filterCheckboxes() {
  const searchText = searchInput.value.toLowerCase();

  // Create two arrays to hold matching and non-matching checkboxes
  const matchingCheckboxes = [];
  const nonMatchingCheckboxes = [];

  checkboxes.forEach((container) => {
    const name = container.querySelector('.checkboxDire').getAttribute('data-name').toLowerCase();

    // Check if the checkbox name contains the search text
    if (name.includes(searchText)) {
      matchingCheckboxes.push(container);
    } else {
      nonMatchingCheckboxes.push(container);
    }
  });

  // Clear the container
  checkboxContainer.innerHTML = '';

  // Append matching checkboxes followed by non-matching checkboxes
  matchingCheckboxes.forEach((container) => {
    checkboxContainer.appendChild(container);
  });

  nonMatchingCheckboxes.forEach((container) => {
    checkboxContainer.appendChild(container);
  });
}

// Get the search input and checkboxes container
const searchInputA = document.getElementById('checkboxSearchActor');
const checkboxContainerA = document.getElementById('checkboxContainerActor');

// Get all checkboxes with the 'checkbox' class
const checkboxesA = document.querySelectorAll('.checkbox-container-Actor');

// Add an event listener to the search input
searchInputA.addEventListener('input', filterCheckboxesA);

function filterCheckboxesA() {
  const searchTextA = searchInputA.value.toLowerCase();

  // Create two arrays to hold matching and non-matching checkboxes
  const matchingCheckboxesA = [];
  const nonMatchingCheckboxesA = [];

  checkboxesA.forEach((container) => {
    const nameA = container.querySelector('.checkboxActor').getAttribute('data-name').toLowerCase();

    // Check if the checkbox name contains the search text
    if (nameA.includes(searchTextA)) {
      matchingCheckboxesA.push(container);
    } else {
      nonMatchingCheckboxesA.push(container);
    }
  });

  // Clear the container
  checkboxContainerA.innerHTML = '';

  // Append matching checkboxes followed by non-matching checkboxes
  matchingCheckboxesA.forEach((container) => {
    checkboxContainerA.appendChild(container);
  });

  nonMatchingCheckboxesA.forEach((container) => {
    checkboxContainerA.appendChild(container);
  });
}

// Get the search input and checkboxes container
const searchInputG = document.getElementById('checkboxSearchGenero');
const checkboxContainerG = document.getElementById('checkboxContainerGenero');

// Get all checkboxes with the 'checkbox' class
const checkboxesG = document.querySelectorAll('.checkbox-container-Genero');

// Add an event listener to the search input
searchInputG.addEventListener('input', filterCheckboxesG);

function filterCheckboxesG() {
  const searchTextG = searchInputG.value.toLowerCase();

  // Create two arrays to hold matching and non-matching checkboxes
  const matchingCheckboxesG = [];
  const nonMatchingCheckboxesG = [];

  checkboxesG.forEach((container) => {
    const nameG = container.querySelector('.checkboxGenero').getAttribute('data-name').toLowerCase();

    // Check if the checkbox name contains the search text
    if (nameG.includes(searchTextG)) {
      matchingCheckboxesG.push(container);
    } else {
      nonMatchingCheckboxesG.push(container);
    }
  });

  // Clear the container
  checkboxContainerG.innerHTML = '';

  // Append matching checkboxes followed by non-matching checkboxes
  matchingCheckboxesG.forEach((container) => {
    checkboxContainerG.appendChild(container);
  });

  nonMatchingCheckboxesG.forEach((container) => {
    checkboxContainerG.appendChild(container);
  });
}
