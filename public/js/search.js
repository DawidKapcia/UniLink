const search = document.querySelector('input[placeholder="Search an event..."]');
const eventContainer = document.querySelector(".events");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const data = {search: this.value};

        fetch("/search", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(function (response) {
            return response.json();
        }).then(function (events) {
            eventContainer.innerHTML = "";
            loadEvents(events)
        });
    }
});

function loadEvents(events) {
    events.forEach(event => {
        console.log(event);
        createEvent(event);
    });
}

function createEvent(event) {
    const template = document.querySelector("#event-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = event.id;

    const a = clone.querySelector("a");
    a.href = "event_details?id=" + div.id;

    const image = clone.querySelector("img");
    image.src = `/public/uploads/${event.image}`;

    const name = clone.querySelector("h3");
    name.innerHTML = event.name;

    const address = clone.querySelector("p");
    address.innerHTML = event.address + ", " + event.zipcode + " " + event.city;

    const date = clone.querySelector(".fa-calendar-days");
    date.innerText = event.date + " " + event.hour;

    const slots = clone.querySelector(".fa-user");
    slots.innerText = event.enroled + "/" + event.maxslots;

    eventContainer.appendChild(clone);
}
