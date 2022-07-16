<template>
    <Pie 
        :chart-options="chartOptions"
        :chart-data="dataChart"
        :chart-id="chartId"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
    />
</template>

<script>
    import {
        Pie
    } from 'vue-chartjs'
    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
        ArcElement,
        CategoryScale,
        Plugin
    } from 'chart.js'

    ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)

    export default {
        name: 'PieChart',
        components: {
            Pie
        },
        props: {
            dataChart:{
                type: Object,
                default: () => {}
            },
            chartId: {
                type: String,
                default: 'pie-chart'
            },
            width: {
                type: Number,
                default: 400
            },
            height: {
                type: Number,
                default: 400
            },
            cssClasses: {
                default: '',
                type: String
            },
            styles: {
                type: Object,
                default: () => {}
            },
            plugins: {
                type: Array,
                default: () => {}
            }
        },
        data() {
            return {
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        }
    }
</script>