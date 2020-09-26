<template>

    <div>
        <div class="flex justify-between items-center bg-30 p-3">
            <h3 class="text-sm uppercase tracking-wide text-80">
                {{ filter.name }}
            </h3>

            <button
                type="button"
                class="btn btn-default btn-primary"
                v-if="filter.showClearButton && hasActivePills"
                @click="clear"
            >
                {{ filter.clearLabel }}
            </button>
        </div>

        <div
            class="flex px-2 pb-2"
            :class="{ 'flex-wrap': !dragMode, 'cursor-move overflow-x-hidden': dragMode }"
            v-dragscroll.x="dragMode"
            v-on:dragscrollstart="onDragStart"
            v-on:dragscrollend="onDragEnd"
            >

            <pill
                v-for="option in filter.options"
                :key="option.value"
                :label="option.label"
                :color="option.color"
                :backgroundColor="option.backgroundColor"
                :colorActive="option.colorActive"
                :backgroundColorActive="option.backgroundColorActive"
                :isActive="value.includes(option.value)"
                @click.native="handleChange(option.value)"
            >
            </pill>

        </div>

    </div>

</template>

<script>
    import { dragscroll } from 'vue-dragscroll'
    import Pill from './Pill'

    export default {
        name: 'PillFilter',
        components: { Pill },
        directives: {
            dragscroll
        },
        data: () => ({
            dragging: false,
            dragTimer: null
        }),
        props: {
            resourceName: {
                type: String,
                required: true,
            },
            filterKey: {
                type: String,
                required: true,
            },
            lens: String,
        },

        methods: {
            onDragStart() {
                if (!this.dragMode) {
                    return
                }

                this.dragTimer = setTimeout(() => this.dragging = true, 100)
            },

            onDragEnd() {
                if (!this.dragMode) {
                    return
                }

                if (this.dragTimer) {
                    clearTimeout(this.dragTimer)
                    this.dragTimer = null
                }

                setTimeout(() => this.dragging = false)
            },

            setValue(value) {
                this.$store.commit(`${this.resourceName}/updateFilterState`, {
                    filterClass: this.filter.class,
                    value: value
                })

                this.$emit('change')
            },

            handleChange(optionValue) {
                if (this.dragging) {
                    return
                }

                const exists = this.value.includes(optionValue)

                const newValue = [ ...this.value ]

                if (this.filter.single || exists) {
                    newValue.splice(newValue.indexOf(optionValue), 1)
                }

                if (!exists) {
                    newValue.push(optionValue)
                }

                this.setValue(newValue)
            },

            clear() {
                this.setValue([])
            },
        },

        computed: {
            filter() {
                return this.$store.getters[`${this.resourceName}/getFilter`](this.filterKey)
            },

            value() {
                return this.filter.currentValue
            },

            hasActivePills() {
                return this.value.length > 0
            },

            dragMode() {
                return this.filter.mode === 'drag'
            }
        },
    }
</script>
