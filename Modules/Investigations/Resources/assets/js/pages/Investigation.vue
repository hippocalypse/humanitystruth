<script>
    //import Replies from '../components/Comments.vue';
    //import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['investigation'],

        //components: {Replies, SubscribeButton},

        data () {
            return {
                repliesCount: this.investigation.replies_count,
                locked: this.investigation.locked,
                title: this.investigation.title,
                body: this.investigation.body,
                form: {},
                editing: false
            };
        },

        created () {
            this.resetForm();
        },

        methods: {
            toggleLock () {
                let uri = `/locked-investigations/${this.investigation.slug}`;

                axios[this.locked ? 'delete' : 'post'](uri);

                this.locked = ! this.locked;
            },

            update () {
                let uri = `/investigations/${this.investigation.channel.slug}/${this.investigation.slug}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.title = this.form.title;
                    this.body = this.form.body;

                    flash('Your thread has been updated.');
                })
            },

            resetForm () {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };

                this.editing = false;
            },
        }
    }
</script>
