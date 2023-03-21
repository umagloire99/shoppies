<template>
    <ul class="list-inline mb-0 lh-1 rating-result">
        <li class="list-inline-item fs-12  mr-1" :class="rating >= 1 ? 'text-primary' : 'text-secondary'"><i class="fas fa-star"></i>
        </li>
        <li class="list-inline-item fs-12  mr-1" :class="rating >= 2 ? 'text-primary' : 'text-secondary'"><i class="fas fa-star"></i>
        </li>
        <li class="list-inline-item fs-12 mr-1" :class="rating >= 3 ? 'text-primary' : 'text-secondary'"><i class="fas fa-star"></i>
        </li>
        <li class="list-inline-item fs-12 mr-1" :class="rating >= 4 ? 'text-primary' : 'text-secondary'"><i class="fas fa-star"></i>
        </li>
        <li class="list-inline-item fs-12 mr-1" :class="rating >= 5 ? 'text-primary' : 'text-secondary'"><i class="fas fa-star"></i>
        </li>
    </ul>
</template>

<script>
export default {
    name: "RatingWidget",
    props:  {
        rating: Number,
        customClass: {
            type: String,
            default: 'list-inline mb-0 lh-1'
        }
    }
}
</script>

<style scoped>

</style>
