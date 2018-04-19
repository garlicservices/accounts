<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class LocaleListener
 */
class LocaleListener
{
    const DEFAULT_LOCALE = 'en';
    const LOCALES = [
        'ru',
        self::DEFAULT_LOCALE,
    ];

    /**
     * Processing kernel.request event
     *
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (Request::METHOD_POST !== $request->getMethod()) {
            return;
        }

        $post = $request->request;
        if (!$post->has('locale')) {
            return;
        }

        $locale = $post->get('locale');
        $request->setLocale($this->checkLocale($locale));
        $post->remove('locale');
    }

    /**
     * Return locale code from predefined
     *
     * @param string $locale
     *
     * @return string
     */
    public function checkLocale(string $locale)
    {
        return in_array($locale, self::LOCALES) ? $locale : self::DEFAULT_LOCALE;
    }
}
