let students = [];
let filteredStudents = [];
let currentPage = 1;
const studentsPerPage = 4;

const search = document.getElementById("search");
const courseFilter = document.getElementById("courseFilter");
const sort = document.getElementById("sort");
const studentContainer = document.getElementById("studentContainer");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const pageNumber = document.getElementById("pageNumber");

fetch("students.json")
    .then(response => response.json())
    .then(data => {
        students = data;
        filteredStudents = [...students];
        displayStudents();
    })
    .catch(error => {
        studentContainer.innerHTML = "<p>Unable to load student data.</p>";
        console.error(error);
    });

function displayStudents() {
    studentContainer.innerHTML = "";

    const start = (currentPage - 1) * studentsPerPage;
    const end = start + studentsPerPage;

    const pageStudents = filteredStudents.slice(start, end);

    if (pageStudents.length === 0) {
        studentContainer.innerHTML = "<p>No students found.</p>";
        return;
    }

    pageStudents.forEach(student => {
        const card = document.createElement("div");

        card.className = "card";

        card.innerHTML = `
            <h2>${student.name}</h2>
            <p><strong>Email:</strong> ${student.email}</p>
            <p><strong>Course:</strong> ${student.course}</p>
            <p><strong>Marks:</strong> ${student.marks}</p>
        `;

        studentContainer.appendChild(card);
    });

    updatePagination();
}

function applyFilters() {
    const searchValue = search.value.toLowerCase();
    const courseValue = courseFilter.value;
    const sortValue = sort.value;

    filteredStudents = students.filter(student => {
        const matchesSearch =
            student.name.toLowerCase().includes(searchValue) ||
            student.email.toLowerCase().includes(searchValue);

        const matchesCourse =
            courseValue === "all" ||
            student.course === courseValue;

        return matchesSearch && matchesCourse;
    });

    if (sortValue === "name") {
        filteredStudents.sort((a, b) =>
            a.name.localeCompare(b.name)
        );
    }

    if (sortValue === "marksHigh") {
        filteredStudents.sort((a, b) =>
            b.marks - a.marks
        );
    }

    if (sortValue === "marksLow") {
        filteredStudents.sort((a, b) =>
            a.marks - b.marks
        );
    }

    currentPage = 1;
    displayStudents();
}

function updatePagination() {
    const totalPages = Math.ceil(
        filteredStudents.length / studentsPerPage
    );

    pageNumber.textContent = `Page ${currentPage} of ${totalPages || 1}`;

    prev.disabled = currentPage === 1;
    next.disabled = currentPage === totalPages || totalPages === 0;
}

search.addEventListener("input", applyFilters);
courseFilter.addEventListener("change", applyFilters);
sort.addEventListener("change", applyFilters);

prev.addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        displayStudents();
    }
});

next.addEventListener("click", () => {
    const totalPages = Math.ceil(
        filteredStudents.length / studentsPerPage
    );

    if (currentPage < totalPages) {
        currentPage++;
        displayStudents();
    }
});