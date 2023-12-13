document.addEventListener("DOMContentLoaded", function() {
    var leaveRequestsList = document.getElementById("leave-requests-list");
    var leaveRequestForm = document.getElementById("leave-request-form");
    var deleteButton = document.getElementById("delete-requests-btn");

    // Проверяваме дали има предишно запазени заявки в localStorage
    var storedLeaveRequests = JSON.parse(localStorage.getItem("leaveRequests")) || [];

    // Възстановяваме предишно запазените заявки на страницата
    storedLeaveRequests.forEach(function(request) {
        addLeaveRequest(request.type, request.startDate, request.endDate);
    });

    leaveRequestForm.addEventListener("submit", function(event) {
        event.preventDefault();

        var leaveType = document.getElementById("leave-type").value;
        var startDate = document.getElementById("start-date").value;
        var endDate = document.getElementById("end-date").value;

        addLeaveRequest(leaveType, startDate, endDate);

        // Запазваме текущата заявка в localStorage
        var currentLeaveRequests = JSON.parse(localStorage.getItem("leaveRequests")) || [];
        currentLeaveRequests.push({ type: leaveType, startDate: startDate, endDate: endDate });
        localStorage.setItem("leaveRequests", JSON.stringify(currentLeaveRequests));

        // Изчистваме формата след изпращане на заявка
        leaveRequestForm.reset();
    });

    deleteButton.addEventListener("click", function() {
        // Изтриваме заявките от localStorage
        localStorage.removeItem("leaveRequests");

        // Изчистваме списъка на страницата
        leaveRequestsList.innerHTML = "";
    });

    function addLeaveRequest(type, startDate, endDate) {
        var listItem = document.createElement("li");
        listItem.textContent = `Тип: ${type}, Начална дата: ${startDate}, Крайна дата: ${endDate}`;
        leaveRequestsList.appendChild(listItem);

        // При добавяне на нова заявка, проверяваме позицията на footer-а
        updateFooterPosition();
    }
    // При прокрутка на страницата, проверяваме позицията на footer-а
    window.addEventListener("scroll", updateFooterPosition);
});
