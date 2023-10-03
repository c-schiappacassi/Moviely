// JavaScript code to collect unchecked checkbox values
document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll("input[type='checkbox']");

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener("change", function() {
            if (!this.checked) {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = `unchecked${this.name}`;
                hiddenInput.value = this.value;
                document.querySelector("form").appendChild(hiddenInput);
            } else {
                const hiddenInput = document.querySelector(
                    `input[name='unchecked${this.name}'][value='${this.value}']`
                );
                if (hiddenInput) {
                    hiddenInput.remove();
                }
            }
        });
    });
});
