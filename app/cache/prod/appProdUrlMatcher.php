<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // ever_fail_main_homepage
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'ever_fail_main_homepage')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/c')) {
            if (0 === strpos($pathinfo, '/ca')) {
                if (0 === strpos($pathinfo, '/category')) {
                    // category
                    if (rtrim($pathinfo, '/') === '/category') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'category');
                        }

                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::indexAction',  '_route' => 'category',);
                    }

                    // category_show
                    if (preg_match('#^/category/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::showAction',));
                    }

                    // category_new
                    if ($pathinfo === '/category/new') {
                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::newAction',  '_route' => 'category_new',);
                    }

                    // category_create
                    if ($pathinfo === '/category/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_category_create;
                        }

                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::createAction',  '_route' => 'category_create',);
                    }
                    not_category_create:

                    // category_edit
                    if (preg_match('#^/category/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::editAction',));
                    }

                    // category_update
                    if (preg_match('#^/category/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_category_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::updateAction',));
                    }
                    not_category_update:

                    // category_delete
                    if (preg_match('#^/category/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                            $allow = array_merge($allow, array('POST', 'DELETE'));
                            goto not_category_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'category_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CategoryController::deleteAction',));
                    }
                    not_category_delete:

                }

                if (0 === strpos($pathinfo, '/car')) {
                    // car
                    if (rtrim($pathinfo, '/') === '/car') {
                        if (substr($pathinfo, -1) !== '/') {
                            return $this->redirect($pathinfo.'/', 'car');
                        }

                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::indexAction',  '_route' => 'car',);
                    }

                    // car_show
                    if (preg_match('#^/car/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'car_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::showAction',));
                    }

                    // car_new
                    if ($pathinfo === '/car/new') {
                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::newAction',  '_route' => 'car_new',);
                    }

                    // car_create
                    if ($pathinfo === '/car/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_car_create;
                        }

                        return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::createAction',  '_route' => 'car_create',);
                    }
                    not_car_create:

                    // car_edit
                    if (preg_match('#^/car/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'car_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::editAction',));
                    }

                    // car_update
                    if (preg_match('#^/car/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                            $allow = array_merge($allow, array('POST', 'PUT'));
                            goto not_car_update;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'car_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::updateAction',));
                    }
                    not_car_update:

                    // car_delete
                    if (preg_match('#^/car/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                            $allow = array_merge($allow, array('POST', 'DELETE'));
                            goto not_car_delete;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'car_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CarController::deleteAction',));
                    }
                    not_car_delete:

                }

            }

            if (0 === strpos($pathinfo, '/customer')) {
                // customer
                if (rtrim($pathinfo, '/') === '/customer') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'customer');
                    }

                    return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::indexAction',  '_route' => 'customer',);
                }

                // customer_show
                if (preg_match('#^/customer/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'customer_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::showAction',));
                }

                // customer_new
                if ($pathinfo === '/customer/new') {
                    return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::newAction',  '_route' => 'customer_new',);
                }

                // customer_create
                if ($pathinfo === '/customer/create') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_customer_create;
                    }

                    return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::createAction',  '_route' => 'customer_create',);
                }
                not_customer_create:

                // customer_edit
                if (preg_match('#^/customer/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'customer_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::editAction',));
                }

                // customer_update
                if (preg_match('#^/customer/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                        $allow = array_merge($allow, array('POST', 'PUT'));
                        goto not_customer_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'customer_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::updateAction',));
                }
                not_customer_update:

                // customer_delete
                if (preg_match('#^/customer/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                        $allow = array_merge($allow, array('POST', 'DELETE'));
                        goto not_customer_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'customer_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\CustomerController::deleteAction',));
                }
                not_customer_delete:

            }

        }

        if (0 === strpos($pathinfo, '/invoice')) {
            // invoice
            if (rtrim($pathinfo, '/') === '/invoice') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'invoice');
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::indexAction',  '_route' => 'invoice',);
            }

            // invoice_show
            if (preg_match('#^/invoice/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'invoice_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::showAction',));
            }

            // invoice_new
            if ($pathinfo === '/invoice/new') {
                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::newAction',  '_route' => 'invoice_new',);
            }

            // invoice_create
            if ($pathinfo === '/invoice/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_invoice_create;
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::createAction',  '_route' => 'invoice_create',);
            }
            not_invoice_create:

            // invoice_edit
            if (preg_match('#^/invoice/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'invoice_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::editAction',));
            }

            // invoice_update
            if (preg_match('#^/invoice/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_invoice_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'invoice_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::updateAction',));
            }
            not_invoice_update:

            // invoice_delete
            if (preg_match('#^/invoice/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_invoice_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'invoice_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\InvoiceController::deleteAction',));
            }
            not_invoice_delete:

        }

        if (0 === strpos($pathinfo, '/part')) {
            // part
            if (rtrim($pathinfo, '/') === '/part') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'part');
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::indexAction',  '_route' => 'part',);
            }

            // part_show
            if (preg_match('#^/part/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'part_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::showAction',));
            }

            // part_new
            if ($pathinfo === '/part/new') {
                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::newAction',  '_route' => 'part_new',);
            }

            // part_create
            if ($pathinfo === '/part/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_part_create;
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::createAction',  '_route' => 'part_create',);
            }
            not_part_create:

            // part_edit
            if (preg_match('#^/part/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'part_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::editAction',));
            }

            // part_update
            if (preg_match('#^/part/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_part_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'part_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::updateAction',));
            }
            not_part_update:

            // part_delete
            if (preg_match('#^/part/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_part_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'part_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\PartController::deleteAction',));
            }
            not_part_delete:

        }

        if (0 === strpos($pathinfo, '/service')) {
            // service
            if (rtrim($pathinfo, '/') === '/service') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'service');
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::indexAction',  '_route' => 'service',);
            }

            // service_show
            if (preg_match('#^/service/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'service_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::showAction',));
            }

            // service_new
            if ($pathinfo === '/service/new') {
                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::newAction',  '_route' => 'service_new',);
            }

            // service_create
            if ($pathinfo === '/service/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_service_create;
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::createAction',  '_route' => 'service_create',);
            }
            not_service_create:

            // service_edit
            if (preg_match('#^/service/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'service_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::editAction',));
            }

            // service_update
            if (preg_match('#^/service/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_service_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'service_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::updateAction',));
            }
            not_service_update:

            // service_delete
            if (preg_match('#^/service/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_service_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'service_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\ServiceController::deleteAction',));
            }
            not_service_delete:

        }

        if (0 === strpos($pathinfo, '/vendor')) {
            // vendor
            if (rtrim($pathinfo, '/') === '/vendor') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'vendor');
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::indexAction',  '_route' => 'vendor',);
            }

            // vendor_show
            if (preg_match('#^/vendor/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'vendor_show')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::showAction',));
            }

            // vendor_new
            if ($pathinfo === '/vendor/new') {
                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::newAction',  '_route' => 'vendor_new',);
            }

            // vendor_create
            if ($pathinfo === '/vendor/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_vendor_create;
                }

                return array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::createAction',  '_route' => 'vendor_create',);
            }
            not_vendor_create:

            // vendor_edit
            if (preg_match('#^/vendor/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'vendor_edit')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::editAction',));
            }

            // vendor_update
            if (preg_match('#^/vendor/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_vendor_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'vendor_update')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::updateAction',));
            }
            not_vendor_update:

            // vendor_delete
            if (preg_match('#^/vendor/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_vendor_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'vendor_delete')), array (  '_controller' => 'EverFail\\MainBundle\\Controller\\VendorController::deleteAction',));
            }
            not_vendor_delete:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
