<?php

use craft\elements\Entry;
use craft\records\EntryType;
use craft\helpers\UrlHelper;
use craft\elements\User;

return [
    'endpoints' => [
        'api/session' => function() {
            return [
                'elementType' => Entry::class,
                'one' => true,
                'transformer' => function(Entry $entry) {
                    $user = Craft::$app->getUser();
                    return [
                        'id' => $user->id,
                        'username' => $user->rememberedUsername,
                    ];
                },
            ];
        },
        'api/messages' => function() {
            return [
                'elementType' => Entry::class,
                'criteria' => ['section' => 'message'],
                'transformer' => function(Entry $entry) {
                    $community = $entry->community->first();
                    return [
                        'title' => $entry->title,
                        'body' => $entry->body,
                        'url' => $entry->url,
                        'post_date' => $entry->postDate,
                        'community' => [
                            'title' => $community->title,
                            'url' => $community->url,
                        ],
                    ];
                },
            ];
        },
        'api/messages/create' => function() {
            return;
            $entry = new Entry;
            $entry->sectionId = 2;
            $entry->typeId = 2;
            $entry->authorId = 1;
            $entry->enabled = true;
            $entry->title = 'Hello World';
            $entry->setFieldValues([
                'body' => 'My message..',
                // 'community' => 33,
            ]);
            $success = Craft::$app->elements->saveElement($entry);
            if (!$success) {
                Craft::error('Couldn’t save the entry "'.$entry->title.'"', __METHOD__);
            }
        },
        'api/entry/<handle:{handle}>' => function($handle) {
            return [
                'elementType' => Entry::class,
                'criteria' => ['section' => $handle],
                'transformer' => function(Entry $entry) {
                    return [
                        'title' => 'Test',
                    ];
                },
            ];
            // return EntryType::find()->where(['handle' => $handle])->one();
        },
        'news/<entryId:\d+>.json' => function($entryId) {
            return [
                'elementType' => Entry::class,
                'criteria' => ['id' => $entryId],
                'one' => true,
                'transformer' => function(Entry $entry) {
                    return [
                        'title' => $entry->title,
                        'url' => $entry->url,
                        'summary' => $entry->summary,
                        'body' => $entry->body,
                    ];
                },
            ];
        },
    ]
];