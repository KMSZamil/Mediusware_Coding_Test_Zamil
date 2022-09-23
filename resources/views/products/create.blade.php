@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
    </div>
    <div id="app">
        <create-product :variants="{{ $variants }}">Loading</create-product>
    </div>

    {{-- <section>
        <form action="{{ route('product.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" name="product_name" placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Product SKU</label>
                                <input type="text" name="product_sku" placeholder="Product Name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                        </div>
                        <div class="card-body border">
                            <input type="file" id="dropzone"></input>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Variants</h6>
                        </div>
                        <div class="card-body clone">
                            <div class="row" v-for="(item,index) in product_variant">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Option</label>
                                        <select name="variant" class="form-control">
                                            @foreach ($variants as $row)
                                                <option value="{{ $row->variant_id }}">
                                                    {{ $row->variant }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label v-if="product_variant.length != 1" class="float-right text-primary"
                                            style="cursor: pointer;">Remove</label>
                                        <label v-else for="">.</label>
                                        <input type="text" class="form-control" name="checkVariant" id="checkVariant">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="clone_space"></div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="add">Add another option</button>
                        </div>

                        <div class="card-header text-uppercase">Preview</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Variant</td>
                                            <td>Price</td>
                                            <td>Stock</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="variant_price in product_variant_prices">
                                            <td></td>
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-lg btn-primary">Save</button>
            <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
        </form>
    </section> --}}
@endsection
