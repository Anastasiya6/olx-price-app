<template>
    <form @submit.prevent="submitForm" class="vertical-form">
        <label for="olx_link">Посилання на OLX оголошення:</label>
        <input v-model="olxLink" type="text" id="olx_link" required>

        <label for="email">Ваша електронна пошта:</label>
        <input v-model="email" type="email" id="email" required>

        <button type="submit">Підписатися</button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            olxLink: '',
            email: '',
            responseMessage: '',
        };
    },
    methods: {
        async submitForm() {
            try {
                const data = {
                    olxLink: this.olxLink,
                    email: this.email,
                };

                this.olxLink = '';
                this.email = '';

                // Відправляє AJAX-запит на сервер за допомогою Axios
                const response = await axios.post('/api/subscription-advert', data);

                // Обробляє результат відправки
                //alert(response.data.success);
            } catch (error) {
                console.error(error);
                alert('Помилка при додаванні підписки');
            }
        },

    },
};
</script>
<style scoped>
.vertical-form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

label {
    margin-bottom: 5px;
}

input {
    margin-bottom: 10px;
}
</style>
