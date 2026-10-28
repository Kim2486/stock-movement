import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ProductController::syncFromKintone
 * @see app/Http/Controllers/ProductController.php:77
 * @route '/sync-kintone'
 */
export const syncFromKintone = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})

syncFromKintone.definition = {
    methods: ["get","head"],
    url: '/sync-kintone',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductController::syncFromKintone
 * @see app/Http/Controllers/ProductController.php:77
 * @route '/sync-kintone'
 */
syncFromKintone.url = (options?: RouteQueryOptions) => {
    return syncFromKintone.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::syncFromKintone
 * @see app/Http/Controllers/ProductController.php:77
 * @route '/sync-kintone'
 */
syncFromKintone.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: syncFromKintone.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ProductController::syncFromKintone
 * @see app/Http/Controllers/ProductController.php:77
 * @route '/sync-kintone'
 */
syncFromKintone.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: syncFromKintone.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductController::bulkDelete
 * @see app/Http/Controllers/ProductController.php:65
 * @route '/products/bulk-delete'
 */
export const bulkDelete = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

bulkDelete.definition = {
    methods: ["post"],
    url: '/products/bulk-delete',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ProductController::bulkDelete
 * @see app/Http/Controllers/ProductController.php:65
 * @route '/products/bulk-delete'
 */
bulkDelete.url = (options?: RouteQueryOptions) => {
    return bulkDelete.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::bulkDelete
 * @see app/Http/Controllers/ProductController.php:65
 * @route '/products/bulk-delete'
 */
bulkDelete.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: bulkDelete.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProductController::index
 * @see app/Http/Controllers/ProductController.php:12
 * @route '/products'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/products',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductController::index
 * @see app/Http/Controllers/ProductController.php:12
 * @route '/products'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::index
 * @see app/Http/Controllers/ProductController.php:12
 * @route '/products'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ProductController::index
 * @see app/Http/Controllers/ProductController.php:12
 * @route '/products'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductController::edit
 * @see app/Http/Controllers/ProductController.php:31
 * @route '/products/{id}/edit'
 */
export const edit = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/products/{id}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProductController::edit
 * @see app/Http/Controllers/ProductController.php:31
 * @route '/products/{id}/edit'
 */
edit.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return edit.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::edit
 * @see app/Http/Controllers/ProductController.php:31
 * @route '/products/{id}/edit'
 */
edit.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ProductController::edit
 * @see app/Http/Controllers/ProductController.php:31
 * @route '/products/{id}/edit'
 */
edit.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProductController::update
 * @see app/Http/Controllers/ProductController.php:37
 * @route '/products/{id}'
 */
export const update = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/products/{id}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ProductController::update
 * @see app/Http/Controllers/ProductController.php:37
 * @route '/products/{id}'
 */
update.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return update.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::update
 * @see app/Http/Controllers/ProductController.php:37
 * @route '/products/{id}'
 */
update.put = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\ProductController::destroy
 * @see app/Http/Controllers/ProductController.php:58
 * @route '/products/{id}'
 */
export const destroy = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/products/{id}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\ProductController::destroy
 * @see app/Http/Controllers/ProductController.php:58
 * @route '/products/{id}'
 */
destroy.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return destroy.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProductController::destroy
 * @see app/Http/Controllers/ProductController.php:58
 * @route '/products/{id}'
 */
destroy.delete = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})
const ProductController = { syncFromKintone, bulkDelete, index, edit, update, destroy }

export default ProductController