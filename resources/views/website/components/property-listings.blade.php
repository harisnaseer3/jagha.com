<div class="page-list-layout">
    @include('website.layouts.list_layout_property_listing')
</div>

<div class="page-grid-layout" style="display: none;">
    @include('website.layouts.grid_layout_property_listing')
</div>
@if($properties->count())
    <!-- Pagination -->
    <div class="pagination-box hidden-mb-45 text-center" role="navigation">

        {{ $properties->links('vendor.pagination.bootstrap-4') }}
    </div>
@endif
