<template>

    <div
        class="rounded-lg form-control cursor-pointer dim text-sm p-2 px-4 mr-2 mt-2 select-none whitespace-no-wrap"
        :style="style"
    >
        {{ label }}
    </div>

</template>

<script>
    export default {
        name: 'Pill',
        props: {
            label: {
                type: String,
                required: true
            },
            color: {
                type: String,
                required: true
            },
            backgroundColor: {
                type: String,
                required: true
            },
            colorActive: {
                type: String,
                required: true
            },
            backgroundColorActive: {
                type: String,
                required: true
            },
            isActive: {
                type: Boolean,
                default: false
            },
        },
        computed: {
            style() {
                return this.isActive
                    ? { "background-color": this.backgroundColorActive, "color": this.colorActive }
                    : { "background-color": this.backgroundColor, "color": this.color }
            },
        }
    }
</script>
