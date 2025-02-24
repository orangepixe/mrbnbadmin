
document.addEventListener('livewire:initialized', () => {
    console.log('Custom JS loaded');
    const reviewsPage = document.getElementById('reviewsPage');

    if (JSON.stringify(reviewsPage) !== "null") {
        console.log('Element Exists');
    } else {
        console.log('Element does not exist');
    }

})

function MyFunction(event) {
    const contentInput = document.getElementById('reviewContent');
    contentInput.value += "#" + event + "# ";
}
