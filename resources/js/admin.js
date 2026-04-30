let message = document.querySelector('.message');

async function post(request) {
    try {
        const response = await fetch(request);
        const result = await response.json();
        message.innerHTML = result.message;
        message.style.display = 'flex';
        console.log("Success:", result);
    } catch (error) {
        console.error("Error:", error);
    }
}

select = document.querySelectorAll('.status');
select.forEach(element => {
    element.addEventListener('change', function(e) {
        post(
            new Request("src/Handler/ServiceHandler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    order_id: e.target.getAttribute('order'),
                    status_id: e.target.value,
                }),
            }));
    })
});