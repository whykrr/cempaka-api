<template>
    <div class="row">
        <router-link to="content/form" class="btn btn-primary ">
            <i class="fa fa-plus"></i>
            Tambah Content
        </router-link>
        <p>
            This is the content page.
        </p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tags</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(content, index) in contents">
                        <td>{{ index + 1 }}</td>
                        <td>{{ content.title }}</td>
                        <td>{{ content.category_content.name }}</td>
                        <td>{{ content.tags }}</td>
                        <td>
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                                Edit
                            </a>
                            <a class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                Hapus
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contents: [],
        };
    },
    mounted() {
        axios.get('/api/content')
            .then(response => {
                this.contents = response.data.data;
            })
    },
    methods: {
        deleteContent(content) {
            axios.delete('/api/content/' + content.id)
                .then(response => {
                    this.contents = this.contents.filter(c => c.id !== content.id);
                })
        }
    },
}
</script>