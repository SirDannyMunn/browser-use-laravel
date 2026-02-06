<?php

namespace BrowserUseLaravel\Resources;

use BrowserUseLaravel\DataTransferObjects\Skill;
use BrowserUseLaravel\DataTransferObjects\SkillSummary;
use BrowserUseLaravel\DataTransferObjects\SkillList;

class SkillsResource extends Resource
{
    /**
     * Get a list of public skills in the marketplace.
     *
     * GET /marketplace/skills
     *
     * @param int $pageSize Number of items per page (default 10)
     * @param int $pageNumber Page number (1-based, default 1)
     */
    public function listMarketplace(int $pageSize = 10, int $pageNumber = 1): SkillList
    {
        $response = $this->http->get('/marketplace/skills', [
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
        ]);
        return SkillList::fromArray($response);
    }

    /**
     * Clone a public marketplace skill to the user's project.
     *
     * POST /marketplace/skills/{skill_id}/clone
     *
     * @param string $skillId The skill ID (UUID)
     */
    public function clone(string $skillId): Skill
    {
        $response = $this->http->post("/marketplace/skills/{$skillId}/clone");
        return Skill::fromArray($response);
    }

    /**
     * Execute a marketplace skill and get the result.
     *
     * POST /marketplace/skills/{skill_id}/execute
     *
     * @param string $skillId The skill ID (UUID)
     * @param array $parameters Input parameters for the skill
     */
    public function execute(string $skillId, array $parameters = []): array
    {
        return $this->http->post("/marketplace/skills/{$skillId}/execute", $parameters);
    }

    /**
     * Create a new custom skill via API.
     *
     * POST /skills
     *
     * @param string $title The title of the skill
     * @param string $description The description of the skill
     * @param string $agentPrompt The prompt/instructions for the agent to follow
     * @param string|null $goal The goal/automation description
     * @param array|null $categories List of categories
     * @param array|null $domains List of domains
     * @param array|null $parameters List of parameter definitions
     * @param array|null $outputSchema Output schema definition
     * @param bool $isPublic Whether the skill is public
     */
    public function create(
        string $title,
        string $description,
        string $agentPrompt,
        ?string $goal = null,
        ?array $categories = null,
        ?array $domains = null,
        ?array $parameters = null,
        ?array $outputSchema = null,
        bool $isPublic = false,
    ): Skill {
        $data = array_filter([
            'title' => $title,
            'description' => $description,
            'agentPrompt' => $agentPrompt,
            'goal' => $goal,
            'categories' => $categories,
            'domains' => $domains,
            'parameters' => $parameters,
            'outputSchema' => $outputSchema,
            'isPublic' => $isPublic,
        ], fn($v) => $v !== null);

        $response = $this->http->post('/skills', $data);
        return Skill::fromArray($response);
    }
}
