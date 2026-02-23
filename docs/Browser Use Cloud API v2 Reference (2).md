# Browser Use Cloud API v2 Reference

This document provides a comprehensive reference for all API endpoints in **Browser Use Cloud API v2**. Each endpoint section includes the HTTP method and URL, a brief description, the OpenAPI specification (YAML), and example code snippets (in multiple languages, including PHP and cURL). All endpoints require an API key, provided via the X-Browser-Use-API-Key header.

## Billing

### Get Account Billing

GET https://api.browser-use.com/api/v2/billing/account – Retrieve authenticated account information, including credit balances and account details[\[1\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/billing/get-account-billing-billing-account-get#:~:text=Get%20authenticated%20account%20information%20including,credit%20balance%20and%20account%20details).

**Reference:** [Get Account Billing – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/billing/get-account-billing-billing-account-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Account Billing  
  version: endpoint\_billing.get\_account\_billing\_billing\_account\_get  
paths:  
  /billing/account:  
    get:  
      operationId: get-account-billing-billing-account-get  
      summary: Get Account Billing  
      description: \>-  
        Get authenticated account information including credit balance and  
        account details.  
      tags:  
        \- billing  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/AccountView'  
        '404':  
          description: Project for a given API key not found\!  
        '422':  
          description: Validation Error  
components:  
  schemas:  
    PlanInfo:  
      type: object  
      properties:  
        planName:  
          type: string  
          description: The name of the plan  
        subscriptionStatus:  
          type: string  
          nullable: true  
          description: The status of the subscription  
        subscriptionId:  
          type: string  
          nullable: true  
          description: The ID of the subscription  
        subscriptionCurrentPeriodEnd:  
          type: string  
          nullable: true  
          description: The end of the current period  
        subscriptionCanceledAt:  
          type: string  
          nullable: true  
          description: The date the subscription was canceled  
      required:  
        \- planName  
        \- subscriptionStatus  
        \- subscriptionId  
        \- subscriptionCurrentPeriodEnd  
        \- subscriptionCanceledAt  
    AccountView:  
      type: object  
      properties:  
        name:  
          type: string  
          nullable: true  
          description: The name of the user  
        totalCreditsBalanceUsd:  
          type: number  
          format: double  
          description: The total credits balance in USD  
        monthlyCreditsBalanceUsd:  
          type: number  
          format: double  
          description: Monthly subscription credits balance in USD  
        additionalCreditsBalanceUsd:  
          type: number  
          format: double  
          description: Additional top-up credits balance in USD  
        rateLimit:  
          type: integer  
          description: The rate limit for the account  
        planInfo:  
          $ref: '\#/components/schemas/PlanInfo'  
          description: The plan information  
        projectId:  
          type: string  
          format: uuid  
          description: The ID of the project  
      required:  
        \- totalCreditsBalanceUsd  
        \- monthlyCreditsBalanceUsd  
        \- additionalCreditsBalanceUsd  
        \- rateLimit  
        \- planInfo  
        \- projectId

#### *Example Request*

\<?php  
$client \= new \\GuzzleHttp\\Client();  
$response \= $client-\>request('GET', 'https://api.browser-use.com/api/v2/billing/account', \[  
  'headers' \=\> \[  
    'X-Browser-Use-API-Key' \=\> '\<apiKey\>',  
  \],  
\]);  
echo $response-\>getBody();

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/billing/account" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

import requests  
url \= "https://api.browser-use.com/api/v2/billing/account"  
headers \= {"X-Browser-Use-API-Key": "\<apiKey\>"}  
response \= requests.get(url, headers=headers)  
print(response.json())

const url \= 'https://api.browser-use.com/api/v2/billing/account';  
const options \= {  
  method: 'GET',  
  headers: {'X-Browser-Use-API-Key': '\<apiKey\>'}  
};  
try {  
  const response \= await fetch(url, options);  
  const data \= await response.json();  
  console.log(data);  
} catch (error) {  
  console.error(error);  
}

package main  
import (  
  "fmt"  
  "io"  
  "net/http"  
)  
func main() {  
  url := "https://api.browser-use.com/api/v2/billing/account"  
  req, \_ := http.NewRequest("GET", url, nil)  
  req.Header.Add("X-Browser-Use-API-Key", "\<apiKey\>")  
  res, \_ := http.DefaultClient.Do(req)  
  defer res.Body.Close()  
  body, \_ := io.ReadAll(res.Body)  
  fmt.Println(string(body))  
}

require 'uri'  
require 'net/http'  
url \= URI("https://api.browser-use.com/api/v2/billing/account")  
http \= Net::HTTP.new(url.host, url.port)  
http.use\_ssl \= true  
request \= Net::HTTP::Get.new(url)  
request\["X-Browser-Use-API-Key"\] \= '\<apiKey\>'  
response \= http.request(request)  
puts response.read\_body

HttpResponse\<String\> response \= Unirest.get("https://api.browser-use.com/api/v2/billing/account")  
  .header("X-Browser-Use-API-Key", "\<apiKey\>")  
  .asString();

var client \= new RestClient("https://api.browser-use.com/api/v2/billing/account");  
var request \= new RestRequest(Method.GET);  
request.AddHeader("X-Browser-Use-API-Key", "\<apiKey\>");  
IRestResponse response \= client.Execute(request);

import Foundation  
let url \= URL(string: "https://api.browser-use.com/api/v2/billing/account")\!  
var request \= URLRequest(url: url)  
request.httpMethod \= "GET"  
request.setValue("\<apiKey\>", forHTTPHeaderField: "X-Browser-Use-API-Key")  
let task \= URLSession.shared.dataTask(with: request) { data, response, error in  
  if let data \= data {  
    print(String(data: data, encoding: .utf8)\!)  
  } else if let error \= error {  
    print(error)  
  }  
}  
task.resume()

---

## Tasks

Task endpoints allow creating and managing AI agent tasks in the cloud.

### List Tasks

GET https://api.browser-use.com/api/v2/tasks – Retrieve a paginated list of AI agent tasks, with optional filters by session, status, and date[\[2\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get#:~:text=Get%20paginated%20list%20of%20AI,filtering%20by%20session%20and%20status)[\[3\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get#:~:text=Enumeration%20of%20possible%20task%20execution,states).

**Reference:** [List Tasks – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/tasks/list-tasks-tasks-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: List Tasks  
  version: endpoint\_tasks.list\_tasks\_tasks\_get  
paths:  
  /tasks:  
    get:  
      operationId: list-tasks-tasks-get  
      summary: List Tasks  
      description: Get paginated list of AI agent tasks with optional filtering.  
      tags:  
        \- tasks  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: pageSize  
          in: query  
          schema:  
            type: integer  
            minimum: 1  
            maximum: 100  
            default: 10  
        \- name: pageNumber  
          in: query  
          schema:  
            type: integer  
            minimum: 1  
            default: 1  
        \- name: sessionId  
          in: query  
          schema:  
            type: string  
            format: uuid  
        \- name: filterBy  
          in: query  
          schema:  
            type: string  
            enum: \[created, started, finished, stopped\]  
        \- name: after  
          in: query  
          schema:  
            type: string  
            format: date-time  
        \- name: before  
          in: query  
          schema:  
            type: string  
            format: date-time  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/TaskList'  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    TaskView:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        sessionId:  
          type: string  
          format: uuid  
        llm:  
          type: string  
        task:  
          type: string  
        status:  
          type: string  
          enum: \[created, started, finished, stopped\]  
        createdAt:  
          type: string  
          format: date-time  
        startedAt:  
          type: string  
          format: date-time  
          nullable: true  
        finishedAt:  
          type: string  
          format: date-time  
          nullable: true  
        metadata:  
          type: object  
        output:  
          type: string  
          nullable: true  
        browserUseVersion:  
          type: string  
          nullable: true  
        isSuccess:  
          type: boolean  
          nullable: true  
        judgement:  
          type: string  
          nullable: true  
        judgeVerdict:  
          type: boolean  
          nullable: true  
    TaskList:  
      type: object  
      properties:  
        items:  
          type: array  
          items:  
            $ref: '\#/components/schemas/TaskView'  
        totalItems:  
          type: integer  
        pageNumber:  
          type: integer  
        pageSize:  
          type: integer  
      required:  
        \- items  
        \- totalItems  
        \- pageNumber  
        \- pageSize

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/tasks?pageSize=10\&pageNumber=1" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

\<?php  
$client \= new \\GuzzleHttp\\Client();  
$response \= $client-\>request('GET', 'https://api.browser-use.com/api/v2/tasks', \[  
  'headers' \=\> \['X-Browser-Use-API-Key' \=\> '\<apiKey\>'\]  
\]);  
echo $response-\>getBody();

### Create Task

POST https://api.browser-use.com/api/v2/tasks – Start a new browser automation task. If no session is specified, a new session is automatically created[\[4\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/create-task-tasks-post#:~:text=You%20can%20either%3A). This endpoint accepts a JSON body defining the task prompt and optional parameters.

**Reference:** [Create Task – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/tasks/create-task-tasks-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Create Task  
  version: endpoint\_tasks.create\_task\_tasks\_post  
paths:  
  /tasks:  
    post:  
      operationId: create-task-tasks-post  
      summary: Create Task  
      description: \>-  
        Start a new task in an existing session, or create a new session to run the task.  
      tags:  
        \- tasks  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              $ref: '\#/components/schemas/CreateTaskRequest'  
      responses:  
        '202':  
          description: Accepted (Task Created)  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/CreateTaskResponse'  
        '400':  
          description: Bad Request Error  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
        '429':  
          description: Too Many Requests Error  
components:  
  schemas:  
    CreateTaskRequest:  
      type: object  
      properties:  
        task:  
          type: string  
          description: The task prompt/instruction for the agent.  
        llm:  
          type: string  
          description: The LLM model to use for the agent.  
          enum: \[gpt-4, claude-2, claude-instant-1, ...\]  \# truncated for brevity  
        startUrl:  
          type: string  
          nullable: true  
          description: The URL to start the task from.  
        maxSteps:  
          type: integer  
          default: 30  
          minimum: 1  
          maximum: 10000  
        structuredOutput:  
          type: string  
          nullable: true  
          description: Stringified JSON schema for the structured output.  
        sessionId:  
          type: string  
          format: uuid  
          nullable: true  
          description: ID of an existing session to run the task in.  
        metadata:  
          type: object  
          additionalProperties:  
            type: string  
          nullable: true  
          description: Up to 10 key-value metadata pairs for the task.  
        secrets:  
          type: object  
          additionalProperties:  
            type: string  
          nullable: true  
          description: Secrets for the task (e.g., credentials).  
        allowedDomains:  
          type: array  
          items:  
            type: string  
          nullable: true  
          description: List of allowed domains for the task.  
        opVaultId:  
          type: string  
          nullable: true  
          description: 1Password vault ID for injecting secrets.  
        highlightElements:  
          type: boolean  
          default: false  
        flashMode:  
          type: boolean  
          default: false  
        thinking:  
          type: boolean  
          default: false  
        vision:  
          oneOf:  
            \- type: boolean  
            \- type: string  
              enum: \[auto\]  
          default: false  
          description: Whether to enable vision (or 'auto').  
        systemPromptExtension:  
          type: string  
          maxLength: 2000  
          default: ""  
          description: Extension to the agent system prompt.  
        judge:  
          type: boolean  
          default: false  
          description: Enable judge mode for task completion evaluation.  
        judgeGroundTruth:  
          type: string  
          maxLength: 10000  
          nullable: true  
        judgeLlm:  
          type: string  
          nullable: true  
          description: LLM model to use for judging (if not provided, default is used).  
        skillIds:  
          type: array  
          items:  
            type: string  
          nullable: true  
          description: List of skill IDs to enable for this task (use \['\*'\] for all).  
      required:  
        \- task  
    CreateTaskResponse:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
          description: Unique identifier for the created task  
        sessionId:  
          type: string  
          format: uuid  
          description: Session ID where the task was created  
      required:  
        \- id  
        \- sessionId

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/tasks" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "task": "Example task instruction" }'

\<?php  
$client \= new \\GuzzleHttp\\Client();  
$response \= $client-\>request('POST', 'https://api.browser-use.com/api/v2/tasks', \[  
  'headers' \=\> \[  
    'X-Browser-Use-API-Key' \=\> '\<apiKey\>',  
    'Content-Type' \=\> 'application/json'  
  \],  
  'json' \=\> \[ 'task' \=\> 'Example task instruction' \]  
\]);  
echo $response-\>getBody();

### Get Task

GET https://api.browser-use.com/api/v2/tasks/{task\_id} – Get detailed information about a specific task, including its status, timestamps, output, and related session[\[5\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=4%20%20%22startedAt%22%3A%20%222024,15T09%3A30%3A00Z)[\[6\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=22%20%20,26).

**Reference:** [Get Task – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/tasks/get-task-tasks-task-id-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Task  
  version: endpoint\_tasks.get\_task\_tasks\_task\_id\_get  
paths:  
  /tasks/{task\_id}:  
    get:  
      operationId: get-task-tasks-task-id-get  
      summary: Get Task  
      description: Get detailed information about a specific task.  
      tags:  
        \- tasks  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: task\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/TaskView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/tasks/\<task\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Update Task

PATCH https://api.browser-use.com/api/v2/tasks/{task\_id} – Control task execution (e.g., stop a running task). This endpoint accepts a JSON body with an "action" field to stop the task, or stop the task and its session[\[7\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch#:~:text=Control%20task%20execution%20with%20stop%2C,stop%20task%20and%20session%20actions)[\[8\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch#:~:text=action%20enum%20Required).

**Reference:** [Update Task – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/tasks/update-task-tasks-task-id-patch)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Update Task  
  version: endpoint\_tasks.update\_task\_tasks\_task\_id\_patch  
paths:  
  /tasks/{task\_id}:  
    patch:  
      operationId: update-task-tasks-task-id-patch  
      summary: Update Task  
      description: Stop or modify an ongoing task (e.g., stop execution).  
      tags:  
        \- tasks  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: task\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                action:  
                  type: string  
                  enum: \[stop, stop\_task\_and\_session\]  
                  description: The action to perform on the task  
              required:  
                \- action  
      responses:  
        '200':  
          description: Updated  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/TaskView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL (stop a running task)  
curl \-X PATCH "https://api.browser-use.com/api/v2/tasks/\<task\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "action": "stop" }'

### Get Task Logs

GET https://api.browser-use.com/api/v2/tasks/{task\_id}/logs – Fetch the execution logs for a specific task (useful for debugging or real-time monitoring of the agent’s actions). The response is typically a JSON or text stream of log entries.

**Reference:** [Get Task Logs – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/tasks/get-task-logs-tasks-task-id-logs-get) *(Note: This returns task log output.)*

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Task Logs  
  version: endpoint\_tasks.get\_task\_logs\_tasks\_task\_id\_logs\_get  
paths:  
  /tasks/{task\_id}/logs:  
    get:  
      operationId: get-task-logs-tasks-task\_id\_logs\_get  
      summary: Get Task Logs  
      description: Retrieve the logs for a specific task execution.  
      tags:  
        \- tasks  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: task\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response (log output)  
          content:  
            text/plain:  
              schema:  
                type: string  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/tasks/\<task\_id\>/logs" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

---

## Sessions

Session endpoints manage browser sessions in which tasks run. An “agent session” is created to execute tasks, optionally tied to a user profile for persistent state.

### List Sessions

GET https://api.browser-use.com/api/v2/sessions – Get a paginated list of sessions for the project (active or stopped sessions, including their status and timestamps).

**Reference:** [List Sessions – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/list-sessions-sessions-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: List Sessions  
  version: endpoint\_sessions.list\_sessions\_sessions\_get  
paths:  
  /sessions:  
    get:  
      operationId: list-sessions-sessions-get  
      summary: List Sessions  
      description: List all browser sessions for the project.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: pageSize  
          in: query  
          schema:  
            type: integer  
            default: 10  
            minimum: 1  
            maximum: 100  
        \- name: pageNumber  
          in: query  
          schema:  
            type: integer  
            default: 1  
            minimum: 1  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                type: object  
                properties:  
                  items:  
                    type: array  
                    items:  
                      $ref: '\#/components/schemas/SessionView'  
                  totalItems:  
                    type: integer  
                  pageNumber:  
                    type: integer  
                  pageSize:  
                    type: integer  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    SessionView:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        status:  
          type: string  
          enum: \[active, stopped\]  
        startedAt:  
          type: string  
          format: date-time  
        liveUrl:  
          type: string  
          nullable: true  
        finishedAt:  
          type: string  
          format: date-time  
          nullable: true  
        publicShareUrl:  
          type: string  
          nullable: true

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/sessions" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Create Session

POST https://api.browser-use.com/api/v2/sessions – Create a new session (browser environment) for running tasks[\[9\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post#:~:text=Create%20a%20new%20session%20with,a%20new%20task)[\[10\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post#:~:text=browserScreenWidth%20integer%20or%20null%20Optional,6144). If a profileId is provided, the session will use that browser profile (cookies, local storage, etc.), otherwise a fresh profile-less session is created.

**Reference:** [Create Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/create-session-sessions-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Create Session  
  version: endpoint\_sessions.create\_session\_sessions\_post  
paths:  
  /sessions:  
    post:  
      operationId: create-session-sessions-post  
      summary: Create Session  
      description: Create a new browser session.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                profileId:  
                  type: string  
                  format: uuid  
                  nullable: true  
                proxyCountryCode:  
                  type: string  
                  nullable: true  
                startUrl:  
                  type: string  
                  nullable: true  
                browserScreenWidth:  
                  type: integer  
                  nullable: true  
                  minimum: 320  
                  maximum: 6144  
                browserScreenHeight:  
                  type: integer  
                  nullable: true  
                  minimum: 320  
                  maximum: 3456  
      responses:  
        '201':  
          description: Created  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/SessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
        '429':  
          description: Too Many Requests Error

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/sessions" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "profileId": null }'

\<?php  
$client \= new \\GuzzleHttp\\Client();  
$response \= $client-\>request('POST', 'https://api.browser-use.com/api/v2/sessions', \[  
  'headers' \=\> \[  
    'X-Browser-Use-API-Key' \=\> '\<apiKey\>',  
    'Content-Type' \=\> 'application/json'  
  \],  
  'json' \=\> \[ 'profileId' \=\> null \]  
\]);  
echo $response-\>getBody();

### Get Session

GET https://api.browser-use.com/api/v2/sessions/{session\_id} – Get detailed information about a session, including its status, associated tasks, live view URL, and public share URL[\[5\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=4%20%20%22startedAt%22%3A%20%222024,15T09%3A30%3A00Z)[\[11\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=liveUrl%20string%20or%20null).

**Reference:** [Get Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/get-session-sessions-session-id-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Session  
  version: endpoint\_sessions.get\_session\_sessions\_session\_id\_get  
paths:  
  /sessions/{session\_id}:  
    get:  
      operationId: get-session-sessions-session\_id-get  
      summary: Get Session  
      description: Get details of a specific browser session, including tasks.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/SessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/sessions/\<session\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Delete Session

DELETE https://api.browser-use.com/api/v2/sessions/{session\_id} – Permanently delete a session and all its associated data (any running tasks will be stopped)[\[12\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-sessions-session-id-delete#:~:text=Delete%20a%20session%20with%20all,its%20tasks).

**Reference:** [Delete Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/delete-session-sessions-session-id-delete)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Delete Session  
  version: endpoint\_sessions.delete\_session\_sessions\_session\_id\_delete  
paths:  
  /sessions/{session\_id}:  
    delete:  
      operationId: delete-session-sessions-session\_id-delete  
      summary: Delete Session  
      description: Delete a session and all its tasks.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '204':  
          description: No Content (session deleted)  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X DELETE "https://api.browser-use.com/api/v2/sessions/\<session\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Update Session

PATCH https://api.browser-use.com/api/v2/sessions/{session\_id} – Stop an active session (and all running tasks in it)[\[13\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch#:~:text=26)[\[14\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch#:~:text=action%20enum%20Required). This is analogous to calling “stop task and session” at once. The request body should include "action": "stop".

**Reference:** [Update Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/update-session-sessions-session-id-patch)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Update Session  
  version: endpoint\_sessions.update\_session\_sessions\_session\_id\_patch  
paths:  
  /sessions/{session\_id}:  
    patch:  
      operationId: update-session-sessions-session\_id-patch  
      summary: Update Session  
      description: Stop a session (terminate the browser and all tasks).  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                action:  
                  type: string  
                  enum: \[stop\]  
      responses:  
        '200':  
          description: Updated  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/SessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X PATCH "https://api.browser-use.com/api/v2/sessions/\<session\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "action": "stop" }'

### Get Session Public Share

GET https://api.browser-use.com/api/v2/sessions/{session\_id}/public-share – Retrieve information about a session’s public share link, including the URL, view count, and last viewed timestamp[\[15\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get#:~:text=1%7B%202%20%20,15T09%3A30%3A00Z%22%206)[\[16\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get#:~:text=shareToken%20string).

**Reference:** [Get Session Public Share – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/get-session-public-share-sessions-session-id-public-share-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Session Public Share  
  version: endpoint\_sessions.get\_session\_public\_share\_sessions\_session\_id\_get  
paths:  
  /sessions/{session\_id}/public-share:  
    get:  
      operationId: get-session-public-share-sessions-session\_id-get  
      summary: Get Session Public Share  
      description: Get public share info for a session.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/SessionShare'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    SessionShare:  
      type: object  
      properties:  
        shareToken:  
          type: string  
        shareUrl:  
          type: string  
        viewCount:  
          type: integer  
        lastViewedAt:  
          type: string  
          format: date-time

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/sessions/\<session\_id\>/public-share" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Create Session Public Share

POST https://api.browser-use.com/api/v2/sessions/{session\_id}/public-share – Create (or retrieve, if it already exists) a public share link for a session[\[17\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-public-share-sessions-session-id-public-share-post#:~:text=Create%20or%20return%20existing%20public,share%20for%20a%20session). This allows anyone with the link to view the session in read-only mode.

**Reference:** [Create Session Public Share – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/create-session-public-share-sessions-session-id-public-share-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Create Session Public Share  
  version: endpoint\_sessions.create\_session\_public\_share\_sessions\_session\_id\_post  
paths:  
  /sessions/{session\_id}/public-share:  
    post:  
      operationId: create-session-public-share-sessions-session\_id-post  
      summary: Create Session Public Share  
      description: Create or return an existing public share link for a session.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '201':  
          description: Created (Share link generated)  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/SessionShare'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/sessions/\<session\_id\>/public-share" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Delete Session Public Share

DELETE https://api.browser-use.com/api/v2/sessions/{session\_id}/public-share – Remove the public share for a session, invalidating the share URL[\[18\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-public-share-sessions-session-id-public-share-delete#:~:text=Remove%20public%20share%20for%20a,session).

**Reference:** [Delete Session Public Share – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/sessions/delete-session-public-share-sessions-session-id-public-share-delete)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Delete Session Public Share  
  version: endpoint\_sessions.delete\_session\_public\_share\_sessions\_session\_id\_delete  
paths:  
  /sessions/{session\_id}/public-share:  
    delete:  
      operationId: delete-session-public-share-sessions-session\_id-delete  
      summary: Delete Session Public Share  
      description: Remove public share for a session.  
      tags:  
        \- sessions  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '204':  
          description: No Content (share removed)  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X DELETE "https://api.browser-use.com/api/v2/sessions/\<session\_id\>/public-share" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

---

## Files

File endpoints manage file uploads and downloads for use within sessions and tasks. They generate **pre-signed URLs** for secure direct upload to or download from cloud storage (e.g., S3).

### Agent Session Upload File Presigned Url

POST https://api.browser-use.com/api/v2/files/sessions/{session\_id}/presigned-url – Generate a secure pre-signed URL for uploading a file to an **agent session** (a session running an agent task)[\[19\]](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post#:~:text=7)[\[20\]](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post#:~:text=url%20string). The client can upload the file (e.g., an image, PDF) directly to the returned URL, and then reference the file in tasks.

**Reference:** [Agent Session Upload File Presigned URL – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Agent Session Upload File Presigned Url  
  version: endpoint\_files.agent\_session\_upload\_file\_sessions\_session\_id\_post  
paths:  
  /files/sessions/{session\_id}/presigned-url:  
    post:  
      operationId: agent-session-upload-file-presigned-url-files-sessions-post  
      summary: Agent Session Upload File Presigned Url  
      description: Generate a presigned URL for uploading files to an agent session.  
      tags:  
        \- files  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                fileName:  
                  type: string  
                  description: The name of the file to upload  
                contentType:  
                  type: string  
                  description: The MIME type of the file  
                  enum: \[image/jpg, image/jpeg, image/png, ...\]  \# truncated  
                sizeBytes:  
                  type: integer  
                  description: Size of the file in bytes  
              required:  
                \- fileName  
                \- contentType  
                \- sizeBytes  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/PresignedUrlResponse'  
        '400':  
          description: Bad Request Error  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
        '500':  
          description: Internal Server Error  
components:  
  schemas:  
    PresignedUrlResponse:  
      type: object  
      properties:  
        url:  
          type: string  
          description: The URL to upload the file to  
        method:  
          type: string  
          description: HTTP method to use for upload (e.g., "POST")  
        fields:  
          type: object  
          additionalProperties:  
            type: string  
          description: Form fields to include in the upload request  
        fileName:  
          type: string  
          description: The name of the file (to refer to in tasks)  
        expiresIn:  
          type: integer  
          description: Number of seconds until the presigned URL expires  
      required:  
        \- url  
        \- method  
        \- fields  
        \- fileName  
        \- expiresIn

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/files/sessions/\<session\_id\>/presigned-url" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{   
           "fileName": "example.jpg",   
           "contentType": "image/jpeg",   
           "sizeBytes": 102400   
         }'

### Browser Session Upload File Presigned Url

POST https://api.browser-use.com/api/v2/files/browsers/{session\_id}/presigned-url – Generate a secure pre-signed URL for uploading a file to a **browser session** (a session used for direct browser control, via DevTools)[\[21\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true#:~:text=200%20Successful)[\[22\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true#:~:text=Successful%20Response). Use this to upload files (e.g., for file inputs in forms) to the remote browser.

**Reference:** [Browser Session Upload File Presigned URL – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post)

*(The OpenAPI specification and request structure are identical to the agent session upload above, except the path uses /files/browsers/.)*

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/files/browsers/\<session\_id\>/presigned-url" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{   
           "fileName": "example.jpg",   
           "contentType": "image/jpeg",   
           "sizeBytes": 102400   
         }'

### Get Task Output File Presigned Url

GET https://api.browser-use.com/api/v2/files/tasks/{task\_id}/output-files/{file\_id} – Get a secure download URL for an output file generated by a task[\[23\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get#:~:text=200%20Retrieved)[\[24\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get#:~:text=Successful%20Response). Use this to download files (screenshots, PDFs, etc.) that an agent task produced as output.

**Reference:** [Get Task Output File Presigned URL – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Task Output File Presigned Url  
  version: endpoint\_files.get\_task\_output\_file\_tasks\_task\_id\_get  
paths:  
  /files/tasks/{task\_id}/output-files/{file\_id}:  
    get:  
      operationId: get-task-output-file-presigned-url-files-tasks-get  
      summary: Get Task Output File Presigned Url  
      description: Get a presigned download URL for a task's output file.  
      tags:  
        \- files  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: task\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
        \- name: file\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                type: object  
                properties:  
                  id:  
                    type: string  
                    format: uuid  
                  fileName:  
                    type: string  
                  downloadUrl:  
                    type: string  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
        '500':  
          description: Internal Server Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/files/tasks/\<task\_id\>/output-files/\<file\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

---

## Profiles

Profiles represent persistent browser state (cookies, local storage, etc.) that can be reused across sessions, often to maintain login sessions between tasks[\[25\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post#:~:text=Profiles%20allow%20you%20to%20preserve,of%20the%20browser%20between%20tasks)[\[26\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post#:~:text=name%20string%20or%20null%20Optional%60,characters).

### List Profiles

GET https://api.browser-use.com/api/v2/profiles – Retrieve a paginated list of browser profiles for the project[\[27\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get#:~:text=Get%20paginated%20list%20of%20profiles)[\[28\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get#:~:text=items%20list%20of%20objects). Profiles store user-specific data that can be synced to sessions.

**Reference:** [List Profiles – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/profiles/list-profiles-profiles-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: List Profiles  
  version: endpoint\_profiles.list\_profiles\_profiles\_get  
paths:  
  /profiles:  
    get:  
      operationId: list-profiles-profiles-get  
      summary: List Profiles  
      description: List all browser profiles for the project.  
      tags:  
        \- profiles  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: pageSize  
          in: query  
          schema:  
            type: integer  
            default: 10  
            minimum: 1  
            maximum: 100  
        \- name: pageNumber  
          in: query  
          schema:  
            type: integer  
            default: 1  
            minimum: 1  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                type: object  
                properties:  
                  items:  
                    type: array  
                    items:  
                      $ref: '\#/components/schemas/ProfileView'  
                  totalItems:  
                    type: integer  
                  pageNumber:  
                    type: integer  
                  pageSize:  
                    type: integer  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    ProfileView:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        createdAt:  
          type: string  
          format: date-time  
        updatedAt:  
          type: string  
          format: date-time  
        name:  
          type: string  
          nullable: true  
        lastUsedAt:  
          type: string  
          format: date-time  
          nullable: true  
        cookieDomains:  
          type: array  
          items:  
            type: string

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/profiles" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Create Profile

POST https://api.browser-use.com/api/v2/profiles – Create a new browser profile. Profiles preserve cookies and other state; typically one profile per user (to maintain that user’s logged-in state across tasks)[\[25\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post#:~:text=Profiles%20allow%20you%20to%20preserve,of%20the%20browser%20between%20tasks).

**Reference:** [Create Profile – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/profiles/create-profile-profiles-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Create Profile  
  version: endpoint\_profiles.create\_profile\_profiles\_post  
paths:  
  /profiles:  
    post:  
      operationId: create-profile-profiles-post  
      summary: Create Profile  
      description: Create a new browser profile for state persistence.  
      tags:  
        \- profiles  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                name:  
                  type: string  
                  maxLength: 100  
                  nullable: true  
      responses:  
        '201':  
          description: Created  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/ProfileView'  
        '402':  
          description: Payment Required Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/profiles" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "name": "Test Profile" }'

### Get Profile

GET https://api.browser-use.com/api/v2/profiles/{profile\_id} – Retrieve details of a specific browser profile, including stored cookie domains and timestamps.

**Reference:** [Get Profile – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/profiles/get-profile-profiles-profile-id-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Profile  
  version: endpoint\_profiles.get\_profile\_profiles\_profile\_id\_get  
paths:  
  /profiles/{profile\_id}:  
    get:  
      operationId: get-profile-profiles-profile\_id-get  
      summary: Get Profile  
      description: Get details of a browser profile.  
      tags:  
        \- profiles  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: profile\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/ProfileView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/profiles/\<profile\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Update Profile

PATCH https://api.browser-use.com/api/v2/profiles/{profile\_id} – Update profile attributes. Currently, the primary updatable field is likely the profile’s name (to label the profile).

**Reference:** [Update Profile – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/profiles/update-profile-profiles-profile-id-patch)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Update Profile  
  version: endpoint\_profiles.update\_profile\_profiles\_profile\_id\_patch  
paths:  
  /profiles/{profile\_id}:  
    patch:  
      operationId: update-profile-profiles-profile\_id-patch  
      summary: Update Profile  
      description: Update a browser profile's metadata (e.g., name).  
      tags:  
        \- profiles  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: profile\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                name:  
                  type: string  
                  maxLength: 100  
                  nullable: true  
      responses:  
        '200':  
          description: Updated  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/ProfileView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL (rename a profile)  
curl \-X PATCH "https://api.browser-use.com/api/v2/profiles/\<profile\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "name": "Renamed Profile" }'

### Delete Browser Profile

DELETE https://api.browser-use.com/api/v2/profiles/{profile\_id} – Permanently delete a browser profile and its stored data[\[29\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/delete-browser-profile-profiles-profile-id-delete#:~:text=Permanently%20delete%20a%20browser%20profile,and%20its%20configuration).

**Reference:** [Delete Browser Profile – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/profiles/delete-browser-profile-profiles-profile-id-delete)

*(OpenAPI is similar to Delete Session above, with path /profiles/{profile\_id}.)*

#### *Example Request*

\# cURL  
curl \-X DELETE "https://api.browser-use.com/api/v2/profiles/\<profile\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

---

## Browsers

“Browser” endpoints manage **long-lived browser sessions** (browser instances accessible via Chrome DevTools Protocol). These are often used for advanced automation or direct control.

### List Browser Sessions

GET https://api.browser-use.com/api/v2/browsers – List active and recently terminated browser sessions, with optional status filters.

**Reference:** *List Browser Sessions – Browser Use Cloud Docs*

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: List Browser Sessions  
  version: endpoint\_browsers.list\_browser\_sessions\_browsers\_get  
paths:  
  /browsers:  
    get:  
      operationId: list-browser-sessions-browsers-get  
      summary: List Browser Sessions  
      description: List browser sessions with optional filtering by status.  
      tags:  
        \- browsers  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: status  
          in: query  
          schema:  
            type: string  
            enum: \[active, stopped\]  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                type: object  
                properties:  
                  items:  
                    type: array  
                    items:  
                      $ref: '\#/components/schemas/BrowserSessionView'  
                  totalItems:  
                    type: integer  
                  pageNumber:  
                    type: integer  
                  pageSize:  
                    type: integer  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    BrowserSessionView:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        status:  
          type: string  
          enum: \[active, stopped\]  
        timeoutAt:  
          type: string  
          format: date-time  
        startedAt:  
          type: string  
          format: date-time  
        liveUrl:  
          type: string  
          nullable: true  
        cdpUrl:  
          type: string  
          nullable: true  
        finishedAt:  
          type: string  
          format: date-time  
          nullable: true

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/browsers" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Create Browser Session

POST https://api.browser-use.com/api/v2/browsers – Start a new **browser session**. This launches a Chrome browser in the cloud that can be controlled via CDP (useful for interactive automation beyond the agent’s capabilities). *Charges apply for browser sessions (e.g., \\$0.05 per minute)*[\[30\]](https://github.com/browser-use/browser-use/blob/main/CLOUD.md#:~:text=browser,05%20per).

**Reference:** [Create Browser Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/browsers/create-browser-session-browsers-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Create Browser Session  
  version: endpoint\_browsers.create\_browser\_session\_browsers\_post  
paths:  
  /browsers:  
    post:  
      operationId: create-browser-session-browsers-post  
      summary: Create Browser Session  
      description: Launch a new browser session (Chrome instance).  
      tags:  
        \- browsers  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                profileId:  
                  type: string  
                  format: uuid  
                  nullable: true  
                headless:  
                  type: boolean  
                  default: true  
                timeoutSeconds:  
                  type: integer  
                  description: Auto-stop time for the browser (seconds)  
                  default: 300  
      responses:  
        '201':  
          description: Created  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/BrowserSessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/browsers" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "profileId": null, "headless": true }'

### Get Browser Session

GET https://api.browser-use.com/api/v2/browsers/{session\_id} – Get details of a specific browser session, including its status, timeout, live view URL, and DevTools (CDP) URL[\[31\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get#:~:text=1%7B%202%20%20,15T09%3A30%3A00Z%22%209)[\[32\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get#:~:text=id%20string%20%60format%3A%20).

**Reference:** [Get Browser Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/browsers/get-browser-session-browsers-session-id-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Get Browser Session  
  version: endpoint\_browsers.get\_browser\_session\_browsers\_session\_id\_get  
paths:  
  /browsers/{session\_id}:  
    get:  
      operationId: get-browser-session-browsers-session\_id-get  
      summary: Get Browser Session  
      description: Get information about a browser session (status, URLs).  
      tags:  
        \- browsers  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/BrowserSessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/browsers/\<session\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Update Browser Session

PATCH https://api.browser-use.com/api/v2/browsers/{session\_id} – Stop a browser session (shut down the remote browser) before its normal timeout[\[33\]](https://github.com/browser-use/browser-use/blob/main/CLOUD.md#:~:text=Update%20Browser%20Session.%20PATCH%20https%3A%2F%2Fapi.browser,Refund%3A%20When). This immediately frees resources. The request body should include "action": "stop".

**Reference:** [Update Browser Session – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/browsers/update-browser-session-browsers-session-id-patch)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Update Browser Session  
  version: endpoint\_browsers.update\_browser\_session\_browsers\_session\_id\_patch  
paths:  
  /browsers/{session\_id}:  
    patch:  
      operationId: update-browser-session-browsers-session\_id-patch  
      summary: Update Browser Session  
      description: Stop an active browser session.  
      tags:  
        \- browsers  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: session\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              properties:  
                action:  
                  type: string  
                  enum: \[stop\]  
      responses:  
        '200':  
          description: Updated  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/BrowserSessionView'  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X PATCH "https://api.browser-use.com/api/v2/browsers/\<session\_id\>" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{ "action": "stop" }'

---

## Skills

Skills are reusable automation “skills” or mini-APIs created from natural language descriptions[\[34\]](https://docs.browser-use.com/customize/skills/basics#:~:text=Basics%20,endpoint%20you%20can%20call%20repeatedly). Users can create custom skills (private to their project) or use public ones from the **Skills Marketplace**.

### List Skills (Marketplace)

GET https://api.browser-use.com/api/v2/marketplace/skills – List public skills available in the Skills Marketplace. This returns skill metadata such as title, description, categories, etc. (It can be filtered by category or search query via query parameters, not shown here).

**Reference:** [Skills Marketplace – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/skills-marketplace/list-skills-marketplace-skills-get)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: List Skills (Marketplace)  
  version: endpoint\_skills.list\_skills\_marketplace\_get  
paths:  
  /marketplace/skills:  
    get:  
      operationId: list-skills-marketplace-skills-get  
      summary: List Marketplace Skills  
      description: Get a list of public skills in the marketplace.  
      tags:  
        \- skills marketplace  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: pageSize  
          in: query  
          schema:  
            type: integer  
            default: 10  
        \- name: pageNumber  
          in: query  
          schema:  
            type: integer  
            default: 1  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                type: object  
                properties:  
                  items:  
                    type: array  
                    items:  
                      $ref: '\#/components/schemas/SkillSummary'  
                  totalItems:  
                    type: integer  
                  pageNumber:  
                    type: integer  
                  pageSize:  
                    type: integer  
components:  
  schemas:  
    SkillSummary:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        title:  
          type: string  
        description:  
          type: string  
        categories:  
          type: array  
          items:  
            type: string  
        domains:  
          type: array  
          items:  
            type: string  
        isPublic:  
          type: boolean  
        currentVersion:  
          type: integer  
        status:  
          type: string  
          enum: \[recording, processing, available, error\]

#### *Example Request*

\# cURL  
curl \-X GET "https://api.browser-use.com/api/v2/marketplace/skills?pageSize=10\&pageNumber=1" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Clone Skill (Marketplace)

POST https://api.browser-use.com/api/v2/marketplace/skills/{skill\_id}/clone – Clone a public marketplace skill into your project[\[35\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=Clone%20a%20public%20marketplace%20skill,to%20the%20user%27s%20project)[\[36\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=skill_id%20string%20Required%20%60format%3A%20). This creates a copy of the skill under your account (so you can execute or modify it). The response includes the new skill’s details.

**Reference:** [Clone Skill – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Clone Skill  
  version: endpoint\_skills.clone\_skill\_marketplace\_skill\_id\_post  
paths:  
  /marketplace/skills/{skill\_id}/clone:  
    post:  
      operationId: clone-skill-marketplace-skill\_id-post  
      summary: Clone Skill  
      description: Clone a public marketplace skill to the user's project.  
      tags:  
        \- skills marketplace  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: skill\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      responses:  
        '200':  
          description: Successful Response  
          content:  
            application/json:  
              schema:  
                $ref: '\#/components/schemas/Skill'  
        '400':  
          description: Bad Request Error  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error  
components:  
  schemas:  
    Skill:  
      type: object  
      properties:  
        id:  
          type: string  
          format: uuid  
        title:  
          type: string  
        description:  
          type: string  
        categories:  
          type: array  
          items:  
            type: string  
        domains:  
          type: array  
          items:  
            type: string  
        status:  
          type: string  
          enum: \[recording, processing, available, error\]  
        parameters:  
          type: array  
          items:  
            type: object  
            properties:  
              name:  
                type: string  
              type:  
                type: string  
              required:  
                type: boolean  
              description:  
                type: string  
              cookieDomain:  
                type: string  
        outputSchema:  
          type: object  
        isEnabled:  
          type: boolean  
        isPublic:  
          type: boolean  
        currentVersion:  
          type: integer  
        createdAt:  
          type: string  
          format: date-time  
        updatedAt:  
          type: string  
          format: date-time  
        slug:  
          type: string  
          nullable: true  
        goal:  
          type: string  
          nullable: true  
        agentPrompt:  
          type: string  
          nullable: true  
        iconUrl:  
          type: string  
          nullable: true  
        firstPublishedAt:  
          type: string  
          format: date-time  
          nullable: true  
        lastPublishedAt:  
          type: string  
          format: date-time  
          nullable: true  
        currentVersionStartedAt:  
          type: string  
          format: date-time  
          nullable: true  
        currentVersionFinishedAt:  
          type: string  
          format: date-time  
          nullable: true  
        code:  
          type: string  
          nullable: true  
          description: Base64 encoded skill code (Enterprise only)  
        clonedFromSkillId:  
          type: string  
          format: uuid  
          nullable: true

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/marketplace/skills/\<skill\_id\>/clone" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>"

### Execute Skill

POST https://api.browser-use.com/api/v2/marketplace/skills/{skill\_id}/execute – Execute a marketplace skill on-demand without cloning it. This runs the skill’s automation and returns the result, given appropriate input parameters in the request body.

**Reference:** [Execute Skill – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/skills-marketplace/execute-skill-marketplace-skills-skill-id-execute-post)

#### *OpenAPI Specification*

openapi: 3.1.1  
info:  
  title: Execute Skill  
  version: endpoint\_skills.execute\_skill\_marketplace\_skill\_id\_post  
paths:  
  /marketplace/skills/{skill\_id}/execute:  
    post:  
      operationId: execute-skill-marketplace-skill\_id-post  
      summary: Execute Skill  
      description: Execute a marketplace skill and get the result.  
      tags:  
        \- skills marketplace  
      parameters:  
        \- name: X-Browser-Use-API-Key  
          in: header  
          required: true  
          schema:  
            type: string  
        \- name: skill\_id  
          in: path  
          required: true  
          schema:  
            type: string  
            format: uuid  
      requestBody:  
        required: true  
        content:  
          application/json:  
            schema:  
              type: object  
              description: Input parameters for the skill (if any)  
      responses:  
        '200':  
          description: Successful Response (skill output)  
          content:  
            application/json:  
              schema:  
                type: object  
                description: The skill's output (structure varies by skill)  
        '404':  
          description: Not Found Error  
        '422':  
          description: Unprocessable Entity Error

#### *Example Request*

\# cURL  
curl \-X POST "https://api.browser-use.com/api/v2/marketplace/skills/\<skill\_id\>/execute" \\  
     \-H "X-Browser-Use-API-Key: \<apiKey\>" \\  
     \-H "Content-Type: application/json" \\  
     \-d '{}'

### Create Skill (Custom Skill via API)

POST https://api.browser-use.com/api/v2/skills – Create a new custom skill via API by providing a description/goal (the backend will generate the skill’s automation). **Note:** Creating skills via API might be asynchronous; the skill’s status may start as "recording" or "processing" until ready[\[37\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=11%20%20,19).

**Reference:** [Skills – Browser Use Cloud Docs](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/skills/create-skill-skills-post)

*(This allows programmatic skill creation, though details of the request schema are omitted here for brevity.)*

---

## Note on Usage and Errors

All endpoints documented above expect the X-Browser-Use-API-Key header for authentication. Common error responses include **404 Not Found** for invalid IDs or inaccessible resources, **422 Unprocessable Entity** for validation errors, and **429 Too Many Requests** if rate limits are exceeded. The HTTP 400 series error codes correspond to various client-side issues as described in each endpoint’s OpenAPI spec. Always check the message or error structure (if any) in the response for more details when an error status is returned.

---

[\[1\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/billing/get-account-billing-billing-account-get#:~:text=Get%20authenticated%20account%20information%20including,credit%20balance%20and%20account%20details) Get Account Billing | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/billing/get-account-billing-billing-account-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/billing/get-account-billing-billing-account-get)

[\[2\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get#:~:text=Get%20paginated%20list%20of%20AI,filtering%20by%20session%20and%20status) [\[3\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get#:~:text=Enumeration%20of%20possible%20task%20execution,states) List Tasks | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/list-tasks-tasks-get)

[\[4\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/create-task-tasks-post#:~:text=You%20can%20either%3A) Create Task | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/create-task-tasks-post](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/create-task-tasks-post)

[\[5\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=4%20%20%22startedAt%22%3A%20%222024,15T09%3A30%3A00Z) [\[6\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=22%20%20,26) [\[11\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get#:~:text=liveUrl%20string%20or%20null) Get Session | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-sessions-session-id-get)

[\[7\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch#:~:text=Control%20task%20execution%20with%20stop%2C,stop%20task%20and%20session%20actions) [\[8\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch#:~:text=action%20enum%20Required) Update Task | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/tasks/update-task-tasks-task-id-patch)

[\[9\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post#:~:text=Create%20a%20new%20session%20with,a%20new%20task) [\[10\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post#:~:text=browserScreenWidth%20integer%20or%20null%20Optional,6144) Create Session | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-sessions-post)

[\[12\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-sessions-session-id-delete#:~:text=Delete%20a%20session%20with%20all,its%20tasks) Delete Session | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-sessions-session-id-delete](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-sessions-session-id-delete)

[\[13\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch#:~:text=26) [\[14\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch#:~:text=action%20enum%20Required) Update Session | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/update-session-sessions-session-id-patch)

[\[15\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get#:~:text=1%7B%202%20%20,15T09%3A30%3A00Z%22%206) [\[16\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get#:~:text=shareToken%20string) Get Session Public Share | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/get-session-public-share-sessions-session-id-public-share-get)

[\[17\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-public-share-sessions-session-id-public-share-post#:~:text=Create%20or%20return%20existing%20public,share%20for%20a%20session) Create Session Public Share | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-public-share-sessions-session-id-public-share-post](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/create-session-public-share-sessions-session-id-public-share-post)

[\[18\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-public-share-sessions-session-id-public-share-delete#:~:text=Remove%20public%20share%20for%20a,session) Delete Session Public Share | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-public-share-sessions-session-id-public-share-delete](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/sessions/delete-session-public-share-sessions-session-id-public-share-delete)

[\[19\]](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post#:~:text=7) [\[20\]](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post#:~:text=url%20string) Agent Session Upload File Presigned Url | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post](https://docs.cloud.browser-use.com/api-reference/latest-api-v-2/files/agent-session-upload-file-presigned-url-files-sessions-session-id-presigned-url-post)

[\[21\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true#:~:text=200%20Successful) [\[22\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true#:~:text=Successful%20Response) Browser Session Upload File Presigned Url | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/browser-session-upload-file-presigned-url-files-browsers-session-id-presigned-url-post?explorer=true)

[\[23\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get#:~:text=200%20Retrieved) [\[24\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get#:~:text=Successful%20Response) Get Task Output File Presigned Url | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/files/get-task-output-file-presigned-url-files-tasks-task-id-output-files-file-id-get)

[\[25\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post#:~:text=Profiles%20allow%20you%20to%20preserve,of%20the%20browser%20between%20tasks) [\[26\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post#:~:text=name%20string%20or%20null%20Optional%60,characters) Create Profile | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/create-profile-profiles-post)

[\[27\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get#:~:text=Get%20paginated%20list%20of%20profiles) [\[28\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get#:~:text=items%20list%20of%20objects) List Profiles | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/list-profiles-profiles-get)

[\[29\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/delete-browser-profile-profiles-profile-id-delete#:~:text=Permanently%20delete%20a%20browser%20profile,and%20its%20configuration) Delete Browser Profile | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/delete-browser-profile-profiles-profile-id-delete](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/profiles/delete-browser-profile-profiles-profile-id-delete)

[\[30\]](https://github.com/browser-use/browser-use/blob/main/CLOUD.md#:~:text=browser,05%20per) [\[33\]](https://github.com/browser-use/browser-use/blob/main/CLOUD.md#:~:text=Update%20Browser%20Session.%20PATCH%20https%3A%2F%2Fapi.browser,Refund%3A%20When) browser-use/CLOUD.md at main \- GitHub

[https://github.com/browser-use/browser-use/blob/main/CLOUD.md](https://github.com/browser-use/browser-use/blob/main/CLOUD.md)

[\[31\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get#:~:text=1%7B%202%20%20,15T09%3A30%3A00Z%22%209) [\[32\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get#:~:text=id%20string%20%60format%3A%20) Get Browser Session | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/browsers/get-browser-session-browsers-session-id-get)

[\[34\]](https://docs.browser-use.com/customize/skills/basics#:~:text=Basics%20,endpoint%20you%20can%20call%20repeatedly) Basics \- Browser Use docs

[https://docs.browser-use.com/customize/skills/basics](https://docs.browser-use.com/customize/skills/basics)

[\[35\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=Clone%20a%20public%20marketplace%20skill,to%20the%20user%27s%20project) [\[36\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=skill_id%20string%20Required%20%60format%3A%20) [\[37\]](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true#:~:text=11%20%20,19) Clone Skill | Browser Use Cloud Docs

[https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true](https://docs.cloud.browser-use.com/api-reference/v-2-api-current/skills-marketplace/clone-skill-marketplace-skills-skill-id-clone-post?explorer=true)