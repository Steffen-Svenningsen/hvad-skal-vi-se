<?php
namespace App\Services;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;

class ContentfulService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            env('CONTENTFUL_DELIVERY_TOKEN'),
            env('CONTENTFUL_SPACE_ID')
        );
    }

    public function getPlaces()
    {
        $query = new Query();
        $query->setContentType('place');

        $entries = $this->client->getEntries($query);

        $places = [];
        foreach ($entries as $entry) {
            $title = $entry->get('placeTitle');
            $description = $entry->get('placeDescription');
            $location = $entry->get('placeLocation');
            $tags = $entry->get('placeLabel');

            $imageUrl = null;
            if ($entry->get('placeImage') instanceof \Contentful\Delivery\Resource\Asset) {
                $asset = $entry->get('placeImage');
                $file = $asset->getFile();
                if ($file) {
                    $imageUrl = 'https:' . $file->getUrl();
                }
            }

            $places[] = [
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'tags' => $tags,
                'image' => $imageUrl,
            ];
        }

        return $places;
    }
}
