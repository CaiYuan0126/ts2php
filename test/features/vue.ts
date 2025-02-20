import Vue, {PropType} from 'vue';

interface User {
    names: string[];
}

export default Vue.extend({
    props: {
        b: String,
        c: Object as PropType<User>
    },
    data() {
        return {
            a: this.b + 1,
            d: this.c.names.map(a => a.length)
        };
    },
    created() {
        const e = this.b.length;
        const g = this.f.toFixed(2);
    },
    computed: {
        f(): number {
            return this.c.names.indexOf("a");
        }
    }
});
