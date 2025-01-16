<div class="faq-section">
    <h2 class="faq-title">Frequently Asked Questions</h2>
    <div class="faq-item">
        <div class="faq-question">
            Lorem ipsum dolor sit amet is dummy text for type testing.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum. Id quis morbi sagittis mi amet id non. Augue proin nibh risus sapien. Dolor ipsum pharetra sollicitudin urna gravida est venenatis. Vitae facilisi nunc nisl nec. Porttitor pellentesque neque amet molestie lacus est bibendum.
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            Lorem ipsum dolor sit amet is dummy text for type testing.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            Lorem ipsum dolor sit amet is dummy text for type testing.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            Lorem ipsum dolor sit amet is dummy text for type testing.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Lorem ipsum dolor sit amet consectetur. Eu a aenean vulputate tristique tortor interdum.
        </div>
    </div>
    <!-- Add more FAQ items as needed -->
</div>

<style>
    .faq-section {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .faq-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .faq-item {
        /*border: 1px solid #ddd;*/
        margin-bottom: 10px;
        /*border-radius: 5px;*/
        overflow: hidden;
    }

    .faq-question {
        background-color: #f5f5f5;
        font-size: 16px;
        font-weight: bold;
        padding: 15px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-answer {
        display: none;
        font-size: 14px;
        padding: 15px;
        background-color: #ffffff;
        /*border-top: 1px solid #ddd;*/
        color: #555;
    }

    .faq-icon {
        font-size: 20px;
        font-weight: bold;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    .faq-item.active .faq-icon {
        transform: rotate(45deg);
    }

</style>

<script>
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            faqItem.classList.toggle('active');
        });
    });

</script>
