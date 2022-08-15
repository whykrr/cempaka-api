<template>
    <div class="row">
        <p>
            This form use for insert content.
        </p>
        <div class="row">
            <div class="col-6">
                <label for="title">
                    Judul
                </label>
                <input type="text" id="title" class="form-control" v-model="form.title">
                <div class="is-invalid" v-if="errors.title">
                    {{ errors.title }}
                </div>
            </div>
            <div class="col-6">
                <label for="category_id">
                    Kategori
                </label>
                <select id="category_id" class="form-control" v-model="form.category_id">
                    <option value="">Pilih Kategori</option>
                    <option v-for="category in categories" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                <div class="is-invalid" v-if="errors.category_id">
                    {{ errors.category_id }}
                </div>
            </div>
            <div class="col-6">
                <label for="tags">
                    Tags
                </label>
                <input type="text" id="tags" class="form-control" v-model="form.tags">
            </div>
            <div class="col-6">
                <label for="content">
                    Content
                </label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control"
                    v-model="form.content"></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" @click="store">
                    <i class="fa fa-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                category_id: '',
                tags: '',
                content: '',
                is_active: 1,
            },
            categories: [],
            errors: {},
        };
    },
    mounted() {
        axios.get('/api/content/categories')
            .then(response => {
                this.categories = response.data.data;
            })
    },
    methods: {
        store() {
            axios.post('/api/content', this.form)
                .then(response => {
                    this.$toast.success('Data berhasil disimpan.');
                    // move to list page
                    this.$router.push('/content');
                }).catch(error => {
                    var validation = error.response.data.validation_error;
                    
                    // remove all class is-invalid from form
                    for (var key in this.form) {
                        var input = this.$el.querySelector('#' + key);
                        if (input) {
                            input.classList.remove('is-invalid');
                        }

                    }

                    for (var key in validation) {
                        validation[key] = validation[key].join('<br>');
                        // add class is-invalid
                        var input = this.$el.querySelector('#' + key);
                        if (input) {
                            input.classList.add('is-invalid');
                        }
                    }
                    console.log(validation);
                    this.errors = validation;
                });
        },
    },
};
</script>