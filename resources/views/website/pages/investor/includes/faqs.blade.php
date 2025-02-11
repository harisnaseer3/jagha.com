<div class="faq-section">
    <h2 class="faq-title">Frequently Asked Questions</h2>
    <div class="faq-item">
        <div class="faq-question">
            Why should I invest in real estate.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Real estate offers stable, long-term growth, passive income through rentals, and protection against inflation.</div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            What types of properties do you offer for investment.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            We provide residential, commercial, and rental properties in high-demand locations to suit various investor needs.
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            How do I get started.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            Simply reach out to our investment advisors, and we will guide you through the process, from property selection to closing the deal.
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question">
            What is the minimum investment required.
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
            The investment amount depends on the property type and location. We offer flexible options, from affordable apartments to high-value luxury estates, to suit different budgets.
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
